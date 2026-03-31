<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use App\Models\GuruMapelKelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {

            // ✅ 1. SIMPAN / UPDATE GURU
            $guru = Guru::firstOrCreate(
                ['username' => $row['username']],
                [
                    'unit_id'  => $row['unit_id'],
                    'nama'     => $row['nama'],
                    'password' => Hash::make($row['password']),
                ]
            );

            // kalau guru sudah ada → update nama & unit saja
            if ($guru->wasRecentlyCreated === false) {
                $guru->update([
                    'unit_id' => $row['unit_id'],
                    'nama'    => $row['nama'],
                ]);
            }

            // ✅ 2. SIMPAN MAPEL (ANTI DUPLIKAT)
            GuruMapelKelas::firstOrCreate([
                'guru_id' => $guru->id,
                'mapel'   => $row['mapel'],
                'kelas'   => $row['kelas'],
            ]);

            // ✅ 3. USER LOGIN (JANGAN RESET PASSWORD SEMBARANGAN)
            $user = User::firstOrCreate(
                ['email' => $row['username']],
                [
                    'name'     => $row['nama'],
                    'password' => Hash::make($row['password']),
                    'role'     => 'guru',
                ]
            );

            // kalau user sudah ada → update nama saja (password jangan diubah)
            if ($user->wasRecentlyCreated === false) {
                $user->update([
                    'name' => $row['nama'],
                ]);
            }

            return $guru;
        });
    }

    // ✅ VALIDASI PER BARIS
    public function rules(): array
    {
        return [
            '*.unit_id'  => 'required|exists:units,id',
            '*.nama'     => 'required|string',
            '*.username' => 'required|string',
            '*.password' => 'required|string|min:6',
            '*.mapel'    => 'required|string',
            '*.kelas'    => 'required',
        ];
    }
}
