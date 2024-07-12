<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\KriteriaMatrix;
use App\Models\Alternatif;
use App\Models\CriteriaWeight;
use App\Models\AlternatifWeight;
use Illuminate\Support\Facades\DB;

class AHPController extends Controller
{
    public function index()
    {
        $title = 'Home';
        return view('home', compact('title'));
    }
    //
    public function setup(Request $request)
    {
        $request->validate([
            'jml_kriteria' => 'required|integer|min:1',
            'jml_alternatif' => 'required|integer|min:1',
        ]);

        $jml_kriteria = $request->input('jml_kriteria');
        $jml_alternatif = $request->input('jml_alternatif');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        KriteriaMatrix::truncate();
        Kriteria::truncate();
        Alternatif::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('input_kriteria', [
            'jml_kriteria' => $jml_kriteria,
            'jml_alternatif' => $jml_alternatif,
            'title' => 'Input Kriteria'
        ]);
    }

    public function inputKriteria(Request $request)
    {
        $jml_kriteria = $request->query('jml_kriteria');
        $jml_alternatif = $request->query('jml_alternatif');
        $title = 'Input Kriteria';

        return view('input_kriteria', compact('jml_kriteria', 'jml_alternatif', 'title'));
    }

    public function saveKriteria(Request $request)
    {
        $request->validate([
            'kriteria' => 'required|array|min:1',
            'kriteria.*' => 'required|string|max:255',
            'labels' => 'required|array|min:1',
            'labels.*' => 'required|string|max:255',
        ]);

        $kriteria = $request->input('kriteria');
        $labels = $request->input('labels');

        foreach ($kriteria as $index => $nama_kriteria) {
            Kriteria::create([
                'nama' => $nama_kriteria,
                'label' => $labels[$index]
            ]);
        }

        return redirect()->route('input_alternatif', [
            'jml_kriteria' => $request->input('jml_kriteria'),
            'jml_alternatif' => $request->input('jml_alternatif'),
            'title' => 'Input Alternatif'
        ]);
    }

    public function inputAlternatif(Request $request)
    {
        $jml_kriteria = $request->query('jml_kriteria');
        $jml_alternatif = $request->query('jml_alternatif');
        $title = 'Input Alternatif';

        return view('input_alternatif', compact('jml_kriteria', 'jml_alternatif', 'title'));
    }

    public function saveAlternatif(Request $request)
    {
        $request->validate([
            'alternatif' => 'required|array|min:1',
            'alternatif.*' => 'required|string|max:255',
        ]);

        $alternatif = $request->input('alternatif');

        foreach ($alternatif as $nama_alternatif) {
            Alternatif::create([
                'nama' => $nama_alternatif,
            ]);
        }

        return redirect()->route('kriteria')->with('success', 'Data berhasil disimpan!');
    }

    public function kriteria()
    {
        $kriteria = Kriteria::all();
        $title = 'Kriteria';

        return view('kriteria', compact('kriteria', 'title'));
    }

    public function saveMatrix(Request $request)
    {
        $request->validate([
            'matrix' => 'required|array',
            'matrix.*.*' => 'required|numeric|min:0',
        ]);

        $matrix = $request->input('matrix');
        KriteriaMatrix::query()->delete();

        foreach ($matrix as $idkriteria1 => $rows) {
            foreach ($rows as $idkriteria2 => $value) {
                KriteriaMatrix::create([
                    'idkriteria1' => $idkriteria1,
                    'idkriteria2' => $idkriteria2,
                    'value' => $value
                ]);
            }
        }

        return redirect()->route('nilai');
    }

    public function getKriteriaAndAlternatif()
    {
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();
        $title = 'Alternatif';

        return view('alternatif', compact('kriteria', 'alternatif', 'title'));
    }

    public function calculateAHP()
    {
        $kriteriaMatrix = KriteriaMatrix::all();
        $kriteria = Kriteria::all();
        $criteriaCount = $kriteria->count();

        // Initialize matrices
        $pairwiseMatrix = [];
        $normalizedMatrix = [];
        $weights = array_fill(0, $criteriaCount, 0);
        $consistencyMatrix = array_fill(0, $criteriaCount, 0);

        // Fill pairwise matrix from database
        foreach ($kriteriaMatrix as $matrix) {
            $pairwiseMatrix[$matrix->idkriteria1][$matrix->idkriteria2] = $matrix->value;
        }

        // Normalize the matrix
        $columnSums = array_fill(0, $criteriaCount, 0);
        for ($j = 0; $j < $criteriaCount; $j++) {
            for ($i = 0; $i < $criteriaCount; $i++) {
                $columnSums[$j] += $pairwiseMatrix[$i + 1][$j + 1];
            }
        }

        for ($i = 0; $i < $criteriaCount; $i++) {
            for ($j = 0; $j < $criteriaCount; $j++) {
                $normalizedMatrix[$i][$j] = $pairwiseMatrix[$i + 1][$j + 1] / $columnSums[$j];
            }
        }

        // Calculate weights
        for ($i = 0; $i < $criteriaCount; $i++) {
            for ($j = 0; $j < $criteriaCount; $j++) {
                $weights[$i] += $normalizedMatrix[$i][$j];
            }
            $weights[$i] /= $criteriaCount;
        }

        // Calculate consistency matrix
        for ($i = 0; $i < $criteriaCount; $i++) {
            for ($j = 0; $j < $criteriaCount; $j++) {
                $consistencyMatrix[$i] += $pairwiseMatrix[$i + 1][$j + 1] * $weights[$j];
            }
        }

        // Calculate lambda max
        $lambdaMax = 0;
        for ($i = 0; $i < $criteriaCount; $i++) {
            $lambdaMax += $consistencyMatrix[$i] / $weights[$i];
        }
        $lambdaMax /= $criteriaCount;

        // Calculate CI
        $ci = ($lambdaMax - $criteriaCount) / ($criteriaCount - 1);

        // Calculate CR
        $ri = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49]; // Nilai RI untuk matriks hingga ukuran 10
        $cr = $ci / $ri[$criteriaCount - 1];

        // Hapus bobot kriteria sebelumnya
        CriteriaWeight::truncate();

        // Simpan bobot kriteria baru ke database
        foreach ($kriteria as $index => $kriteria_item) {
            CriteriaWeight::create([
                'kriteria_id' => $kriteria_item->id,
                'weight' => $weights[$index]
            ]);
        }

        // Mengembalikan hasil perhitungan ke view
        $title = 'Normalisasi';
        return view('nilai', compact('normalizedMatrix', 'weights', 'ci', 'cr', 'kriteria', 'title'));
    }

    public function calculateAlternatif(Request $request)
    {
        $matrix = $request->input('matrix');
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();
        $criteriaCount = $kriteria->count();
        $alternatifCount = $alternatif->count();

        $alternatifNames = $alternatif->pluck('nama')->toArray();
        $criteriaNames = $kriteria->pluck('nama')->toArray();
        $criteriaLabels = $kriteria->pluck('label')->toArray();

        // Inisialisasi array weights
        $weights = [];
        $normalizedMatrix = [];
        foreach ($kriteria as $kIndex => $kriteriaItem) {
            $kId = $kriteriaItem->id;
            $label = $kriteriaItem->label;
            $columnSums = array_fill(0, $alternatifCount, 0);

            // Fill pairwise matrix
            $pairwiseMatrix = [];
            foreach ($alternatif as $a1Index => $a1) {
                foreach ($alternatif as $a2Index => $a2) {
                    $horizontalValue = $matrix[$a1->id][$kId];
                    $verticalValue = $matrix[$a2->id][$kId];
                    if ($label === 'cost') {
                        $pairwiseMatrix[$a1->id][$a2->id] = $verticalValue / $horizontalValue;
                    } else { // Benefit
                        $pairwiseMatrix[$a1->id][$a2->id] = $horizontalValue / $verticalValue;
                    }
                    $columnSums[$a2Index] += $pairwiseMatrix[$a1->id][$a2->id];
                }
            }

            // Normalize the matrix
            foreach ($alternatif as $a1Index => $a1) {
                foreach ($alternatif as $a2Index => $a2) {
                    if ($columnSums[$a2Index] == 0) {
                        // Avoid division by zero
                        $normalizedMatrix[$a1->id][$kId][$a2->id] = 0;
                    } else {
                        $normalizedMatrix[$a1->id][$kId][$a2->id] = $pairwiseMatrix[$a1->id][$a2->id] / $columnSums[$a2Index];
                    }
                }
            }

            // Calculate weights for this criterion
            $criterionWeights = [];
            foreach ($alternatif as $a1Index => $a1) {
                $sumRow = array_sum($normalizedMatrix[$a1->id][$kId]);
                $criterionWeights[$a1->id] = $sumRow / $alternatifCount;
                $weights[$a1->id][$kId] = $criterionWeights[$a1->id];
            }
        }

        // Calculate final ranking
        $globalWeights = CriteriaWeight::pluck('weight')->toArray(); // Assuming you have global weights for criteria
        $finalScores = [];
        foreach ($alternatif as $aIndex => $a) {
            $finalScore = 0;
            foreach ($kriteria as $kIndex => $k) {
                $finalScore += $weights[$a->id][$k->id] * $globalWeights[$kIndex];
            }
            $finalScores[$a->id] = $finalScore;
        }

        // Save alternative weights to the database
        AlternatifWeight::truncate();
        foreach ($alternatif as $aIndex => $a) {
            foreach ($kriteria as $kIndex => $k) {
                AlternatifWeight::create([
                    'alternatif_id' => $a->id,
                    'kriteria_id' => $k->id,
                    'weight' => $weights[$a->id][$k->id]
                ]);
            }
        }

        $title = 'Alternatif';
        return redirect()->route('ranking');
    }

    public function showRanking()
    {
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();

        // Ambil bobot alternatif dari database
        $alternatifWeights = AlternatifWeight::all();

        // Ambil bobot kriteria dari database
        $criteriaWeights = CriteriaWeight::pluck('weight', 'kriteria_id')->toArray();

        // Hitung nilai akhir untuk setiap alternatif
        $rankings = [];
        foreach ($alternatif as $alt) {
            $totalScore = 0;
            foreach ($kriteria as $kri) {
                $weight = $criteriaWeights[$kri->id] ?? 0;
                $altWeight = $alternatifWeights->where('alternatif_id', $alt->id)->where('kriteria_id', $kri->id)->first()->weight ?? 0;
                $totalScore += $weight * $altWeight;
            }
            $rankings[] = [
                'alternatif' => $alt->nama,
                'score' => $totalScore,
            ];
        }

        // Urutkan berdasarkan nilai akhir
        usort($rankings, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('ranking', compact('rankings'));
    }

    public function alternatifRanking()
    {
        // Mengambil data dari database
        $kriteria = Kriteria::all();
        $alternatif = Alternatif::all();
        $criteriaWeights = CriteriaWeight::pluck('weight', 'kriteria_id')->toArray();
        $alternativeWeights = AlternatifWeight::all()->groupBy('alternatif_id');

        // Menghitung nilai akhir setiap alternatif
        $finalScores = [];
        foreach ($alternatif as $alt) {
            $score = 0;
            foreach ($kriteria as $k) {
                $score += $alternativeWeights[$alt->id]->where('kriteria_id', $k->id)->first()->weight * $criteriaWeights[$k->id];
            }
            $finalScores[$alt->id] = $score;
        }

        // Urutkan alternatif berdasarkan nilai akhir
        arsort($finalScores);

        // Mengembalikan hasil perhitungan ke view
        $title = 'Perankingan Alternatif';
        return view('ranking', compact('finalScores', 'alternatif', 'kriteria', 'title'));
    }
}