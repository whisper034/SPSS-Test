@extends('layouts.main')

@section('style')
<style>
.text{
    line-height:2;
}

@media (max-width: 768px) {
    .text{
        line-height:1.8;
    }
}

</style>
@endsection

@section('title','About')

@section('site-content')
<div class="">
<div class="container" style="margin-top: 70px; margin-bottom: 70px;">
    <div style="text-align: left;">
        <img src="{{ asset('storage/assets/images/text bersinar dan simbol spss.png') }}" alt="spss-about" width="370px">
    </div>

    <p class="text text-white text-justify about-description" style="font-size: 1.3em;">
        <strong><i>SPSS</i></strong> atau <b><i>Statistical Project for Smart Students</i></b> adalah acara berskala nasional yang diadakan oleh Himpunan Mahasiswa Statistika (HIMSTAT) BINUS University. SPSS tahun ini bertemakan "Data 5.0 Mission: Probability Over Reality". Dengan mengangkat tema tersebut, diharapkan data science dapat dikenal lebih dalam oleh masyarakat, terutama mahasiswa. Dengan pelaksanaan SPSS 2022 ini, diharapkan mahasiswa menjadi lebih siap untuk bersaing dalam dunia profesional.
    </p>

    <p class="text text-white text-justify about-description" style="font-size: 1.3em; margin-top: 25px; margin-bottom: 30px;">
        Serangkaian kegiatan yang diadakan dalam SPSS 2021 adalah lomba statistika, lomba essay, lomba infografis, dan <i>webinar</i>. Lomba statistika akan dilaksanakan dalam tiga tahap, sedangkan lomba essay dan infografis akan dilakukan dalam satu tahap. Webinar akan membahas lebih dalam tentang peran data science terhadap pengembangan ekonomi di Indonesia. Dengan pelaksanaan SPSS 2022, seluruh partisipan diharapkan akan mendapat pengalaman dan wawasan dalam memproses data sebagai bentuk persiapan dalam memasuki dunia pekerjaan.
    </p>

    <div style="text-align: right; margin: 0;">
        <img src="{{ asset('storage/assets/images/text bersinar dan simbol tujuan.png') }}" alt="tujuan-spss" width="370px">
    </div>

    <p class="text text-white text-justify about-description" style="margin-bottom: 64px;">
        SPSS memiliki beberapa tujuan, yaitu: memperkenalkan lebih dalam tentang Jurusan/Departemen/Program Studi Teknik Informatika dan Statistika kepada masyarakat luas; menjadi wadah untuk mempersiapkan talenta-talenta muda yang kompetitif, sportif, serta siap bersaing di dunia kerja; menjadi sarana untuk mengembangkan pengetahuan dalam rangka memotivasi para mahasiswa untuk berinovasi dalam penyelesaian masalah dan solusi bidang statistika; dan memperluas hubungan, relasi, dan koneksi dengan para mahasiswa dari Perguruan Tinggi di Indonesia.
    </p>
</div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.play-btn').click(function(){
            $('.play-btn').hide();
            $('.video').show();
            $('.video').get(0).play();
        });
    });
</script>
@endsection
