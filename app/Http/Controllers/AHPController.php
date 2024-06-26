<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\KriteriaMatrix;
use Illuminate\Support\Facades\DB;

class AHPController extends Controller
{
    public function index()
    {
        $title = 'Home';
        return view('home', compact('title'));
    }

    public function setup(Request $request)
    {
        $jml_kriteria = $request->input('jml_kriteria');
        $jml_alternatif = $request->input('jml_alternatif');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing kriteria and kriteria matrix in the database
        KriteriaMatrix::truncate();
        Kriteria::truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Redirect to input kriteria view
        return redirect()->route('input_kriteria', [
            'jml_kriteria' => $jml_kriteria,
            'jml_alternatif' => $jml_alternatif
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
        $kriteria = $request->input('kriteria');
        $labels = $request->input('labels');

        // Save kriteria to the database
        foreach ($kriteria as $index => $nama_kriteria) {
            Kriteria::create([
                'nama' => $nama_kriteria,
                'label' => $labels[$index]
            ]);
        }

        // Redirect to kriteria matrix input view
        return redirect()->route('kriteria');
    }

    public function kriteria()
    {
        $kriteria = Kriteria::all();
        $title = 'Kriteria';

        return view('kriteria', compact('kriteria', 'title'));
    }

    public function saveMatrix(Request $request)
    {
        $matrix = $request->input('matrix');

        // Clear existing matrix in the database
        KriteriaMatrix::query()->delete();

        // Save matrix values to the database
        foreach ($matrix as $idkriteria1 => $rows) {
            foreach ($rows as $idkriteria2 => $value) {
                KriteriaMatrix::create([
                    'idkriteria1' => $idkriteria1,
                    'idkriteria2' => $idkriteria2,
                    'value' => $value
                ]);
            }
        }

        // Redirect to a relevant page after saving
        return redirect()->route('kriteria');
    }
}