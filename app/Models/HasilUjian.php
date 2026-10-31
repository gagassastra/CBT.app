<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    //

    protected $guarded = [];
    public function pesertaUjian() {
        return $this->belongsTo(PesertaUjian::class);
    }

    /**
     * Hitung (ulang) hasil ujian seorang peserta.
     * Nilai = total poin diperoleh / total poin semua soal x 100.
     * Pilihan ganda: poin penuh bila benar. Esai: poin sesuai skor dari guru
     * (esai yang belum dikoreksi dihitung 0 sementara).
     */
    public static function hitung(PesertaUjian $peserta, Ujian $ujian): self
    {
        $soals = $ujian->relationLoaded('soals') ? $ujian->soals : $ujian->soals()->get();
        $jawabans = JawabanSiswa::where('peserta_ujian_id', $peserta->id)->get()->keyBy('soal_id');

        $benar = $salah = $kosong = $esaiPending = 0;
        $totalPoin = 0.0;
        $poinDiperoleh = 0.0;

        foreach ($soals as $soal) {
            $bobot = max(0, (float) ($soal->bobot ?? 1));
            $totalPoin += $bobot;

            $jawab = $jawabans->get($soal->id);
            if (!$jawab || trim((string) $jawab->jawaban) === '') {
                $kosong++;
                continue;
            }

            if ($soal->isEsai()) {
                if ($jawab->skor === null) {
                    $esaiPending++;
                } else {
                    $poinDiperoleh += min((float) $jawab->skor, $bobot);
                }
            } elseif ($jawab->jawaban === $soal->jawaban_benar) {
                $benar++;
                $poinDiperoleh += $bobot;
            } else {
                $salah++;
            }
        }

        $nilai = $totalPoin > 0 ? ($poinDiperoleh / $totalPoin) * 100 : 0;

        return self::updateOrCreate(
            ['peserta_ujian_id' => $peserta->id],
            [
                'jumlah_benar' => $benar,
                'jumlah_salah' => $salah,
                'tidak_dijawab' => $kosong,
                'esai_belum_dinilai' => $esaiPending,
                'nilai_akhir' => $nilai,
            ]
        );
    }

}
