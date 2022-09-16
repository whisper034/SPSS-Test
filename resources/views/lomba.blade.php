@extends('layouts.main')

@section('style')
    <style>
        .w-custom {
            width: 75%;
            position: relative;
            margin: auto;
        }

        .btn-unduh {
            width: 50%;
        }

        .btn-daftar {
            width: 20%;
        }

        .tl1 {
            display: inline;
            margin: 60px auto;
        }

        .tl2 {
            display: none;
            margin-top: 50px;
            margin-bottom: 32px;
            width: 95%;
        }

        .slideshow-container {
            max-width: 100%;
            position: relative;
            margin: auto;
        }

        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 48%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: calc(18px + 0.5vw);
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        .prev {
            left: 12.5%;
        }

        .next {
            right: 12.5%;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover, .next:hover {
            background-color: #1f1955ab
        }

        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #974c7b;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active, .dot:hover {
            background-color: #d83098;
        }

        @media (max-width: 768px) {
            .prev {
                left: 0;
            }

            .next {
                right: 0;
            }

            .w-custom {
                width: 100%
            }

            .btns {
                display: flex;
                flex-direction: column;
            }

            .btn-unduh {
                margin: 10px 10%;
                width: 80%;
            }

            .btn-daftar {
                margin: 10px 10%;
                width: 80%;
            }

            .tl1 {
                display: none;
            }

            .tl2 {
                display: inline;
            }
        }
    </style>
@endsection

@section('title','Lomba')

@section('site-content')
    <div class="container" style="margin-top: 70px; margin-bottom: 70px;">
        <div class="text-white" style="margin-bottom: 60px;">
            <div style="font-weight: bold; text-align: center; margin-bottom: 30px;">
                <span class="sub-heading">
                    Ketentuan Umum Lomba SPSS 2022
                </span>
            </div>

            <table style="font-size: 24px;">
                <colgroup>
                    <col style="width: 3%;">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <td style="vertical-align: top;">1.</td>
                    <td style="vertical-align: top;">Peserta merupakan <strong>mahasiswa D3/D4/S1</strong> di perguruan tinggi Indonesia.</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">2.</td>
                    <td style="vertical-align: top;">Setelah mendaftarkan diri, peserta <strong>tidak boleh digantikan</strong> oleh orang lain.</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">3.</td>
                    <td style="vertical-align: top;">Peserta yang tidak memenuhi persyaratan dan melanggar peraturan dianggap <strong>gugur/diskualifikasi</strong>.</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">4.</td>
                    <td style="vertical-align: top;">Nama Peserta yang dicantumkan saat pendaftaran akan menjadi nama yang dicantumkan ke sertifikat. <strong>Panitia tidak bertanggung jawab atas kesalahan penulisan</strong> saat proses pendaftaran peserta.</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">5.</td>
                    <td style="vertical-align: top;">Semua peraturan wajib diikuti. Peserta akan <strong>didiskualifikasi</strong> oleh panitia secara langsung jika diketahui melanggar peraturan.</td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">6.</td>
                    <td style="vertical-align: top;">Panitia akan mengundang peserta untuk masuk ke dalam grup via Telegram. Pastikan nomor telepon peserta merupakan nomor yang benar. <strong>Panitia tidak bertanggung jawab</strong> atas kesalahan registrasi nomor telepon oleh peserta.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="text-white" style="margin-bottom: 60px; text-align: center;">
            <div style="font-weight: bold;">
                <span class="sub-heading">
                    Benefit
                </span>
            </div>
            <br>
            <div style="font-size: 24px;">
                <span>Hadiah berupa uang tunai senilai jutaan rupiah bagi</span>
                <br>
                <span>pemenang dan sertifikat elektronik bagi seluruh peserta</span>
                <br>
                <span>lomba serta bagi para pemenang.</span>
            </div>
        </div>

        <div class="lomba text-center text-white darkbluebox w-custom" style="margin: 72px auto 24px; padding: 24px;">
            <div>
                <img src="{{ asset('storage/assets/images/text bercahaya statistika.png') }}" alt="text-statistika" height="80px">
            </div>

            <div class="countdown text-center text-white">
                <div class="countdown-content w-custom" style="">
                    <span class="countdown-timer" id="time" style="font-size: calc(40px + 1.5em); font-weight: bold;">00:00:00:00</span>
                </div>
                <span style="font-style: italic; font-size: 18px;">sebelum pendaftaran ditutup</span>
            </div>

            <div style="margin-top: 30px;">
                <img src="{{ asset('storage/assets/images/timeline statistika.png') }}" alt="timeline statistika" width="700px">
            </div>

            <div style="margin-top: 30px; margin-left: 20px; margin-right: 20px; font-size: 22px;">
                <p>
                    Olimpiade Statistika Nasional merupakan bentuk pengembangan dalam ilmu pengetahuan statistika yang dapat menjadi ajang bagi peserta untuk menunjukkan kemampuan dalam menganalisis data serta pemahaman teoritis mengenai statistik. Peserta akan melakukan penyelesaian atas beragam soal dan kasus yang berkaitan dengan statistika. Olimpiade ini terdiri dari 3 (tiga) babak, yakni: Babak 1 (Penyisihan), Babak 2 (Isian dan Essay), dan terakhir Babak 3 (Studi Kasus dan Presentasi).
                </p>
            </div>

            <div style="text-align: center; font-size: 24px; margin-top: 30px;">
                <span style="font-weight: bold;">Jenis Perlombaan: Tim (3 anggota)</span>
                <br>
                <span>Biaya Pendaftaran: Rp75.000,-</span>
            </div>

            <div class="btns text-center" style="margin-top: 30px;">
                <a class="btn btn-outline-info fit-content-btn btn-daftar" href="/register">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn btn-unduh"
                   href="https://drive.google.com/drive/folders/1x7jsfBPMU90oTqjU2eQ0BasTH35lWtoo" target="_blank">Syarat dan Ketentuan</a>
            </div>
        </div>

        <div class="lomba text-center text-white darkbluebox w-custom" style="margin: 72px auto 24px; padding: 24px;">
            <div>
                <img src="{{ asset('storage/assets/images/text bercahaya essay.png') }}" alt="text-essay" height="80px">
            </div>

            <div style="margin-top: 30px;">
                <img src="{{ asset('storage/assets/images/timeline essay.png') }}" alt="timeline essay" width="700px">
            </div>

            <div style="margin-top: 30px; margin-left: 20px; margin-right: 20px; font-size: 22px;">
                <p>
                    Lomba Esai Nasional merupakan lomba yang diadakan sebagai sarana untuk menguji pengetahuan dan kreativitas peserta dalam bidang yang berhubungan dengan statistika dan data science melalui media tulisan. Lomba ini dilaksanakan hanya dalam 1 babak. Untuk lomba esai, SPSS tahun ini mengambil topik yaitu <strong>"Penggunaan Sains Data dalam Pengambilan Keputusan pada Industri di Indonesia"</strong> dengan subtopik yaitu <strong><i>industri manufaktur (e.g. elektronik, obat-obatan, makanan dan minuman) dan industri jasa (e.g. transportasi, pendidikan, perbankan)</i></strong>.
                </p>
            </div>

            <div style="text-align: center; font-size: 24px; margin-top: 30px;">
                <span style="font-weight: bold;">Jenis Perlombaan: Individu</span>
                <br>
                <span>Biaya Pendaftaran: Rp20.000,-</span>
            </div>

            <div class="btns text-center" style="margin-top: 30px;">
                <a class="btn btn-outline-info fit-content-btn btn-daftar" href="https://forms.gle/XimgNeFVUfhjeuYa7" target="_blank">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn btn-unduh"
                   href="https://drive.google.com/drive/folders/11vLFTf6W0cKUEu4hc7h7u5gie5_CiCeh" target="_blank">Syarat dan Ketentuan</a>
            </div>
        </div>

        <div class="lomba text-center text-white darkbluebox w-custom" style="margin: 72px auto 24px; padding: 24px;">
            <div>
                <img src="{{ asset('storage/assets/images/text bercahaya infografis.png') }}" alt="text-infografis" height="80px">
            </div>

            <div style="margin-top: 30px;">
                <img src="{{ asset('storage/assets/images/timeline infografis.png') }}" alt="timeline infografis" width="700px">
            </div>

            <div style="margin-top: 30px; margin-left: 20px; margin-right: 20px; font-size: 22px;">
                <p>
                    Lomba Infografis Nasional merupakan lomba untuk menguji kreativitas peserta dalam memaparkan informasi atau data secara menarik dan informatif. Lomba ini dilaksanakan hanya dalam 1 babak. Untuk lomba infografis, SPSS tahun ini mengambil topik yaitu <strong>"Pentingnya Ilmu Statistika untuk Mempersiapkan Mahasiswa Menghadapi Tantangan Revolusi Industri 5.0"</strong> dengan subtopik yaitu <strong><i>ekonomi, kesehatan, bisnis, pendidikan, sosiokultural, dan ketenagakerjaan</i></strong>.
                </p>
            </div>

            <div style="text-align: center; font-size: 24px; margin-top: 30px;">
                <span style="font-weight: bold;">Jenis Perlombaan: Individu</span>
                <br>
                <span>Biaya Pendaftaran: Rp40.000,-</span>
            </div>

            <div class="btns text-center" style="margin-top: 30px;">
                <a class="btn btn-outline-info fit-content-btn btn-daftar" href="https://forms.gle/yHdy1LCoQcPHJ2UH7" target="_blank">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn btn-unduh"
                   href="https://drive.google.com/drive/folders/1UXNY10dbDtS03pVSLdkv7TGvlMX2nOg8" target="_blank">Syarat dan Ketentuan</a>
            </div>
        </div>

{{--        <div class="lomba-galeri text-center text-white">--}}
{{--            <div class="lomba-galeri-header">--}}
{{--                <span class="heading-lomba" style="font-family: 'Comfoorta';">Galeri</span><br/>--}}
{{--            </div>--}}
{{--            <div class="lomba-galeri-image" style="margin-bottom:36px">--}}
{{--                <div class="slideshow-container">--}}
{{--                    <div class="mySlides"><img src="{{ asset('storage/assets/images/gallery_1.jpg') }}"--}}
{{--                                               class="w-custom"></div>--}}
{{--                    <div class="mySlides"><img src="{{ asset('storage/assets/images/gallery_2.jpg') }}"--}}
{{--                                               class="w-custom"></div>--}}
{{--                    <div class="mySlides"><img src="{{ asset('storage/assets/images/gallery_3.jpg') }}"--}}
{{--                                               class="w-custom"></div>--}}
{{--                    <div class="mySlides"><img src="{{ asset('storage/assets/images/gallery_4.jpg') }}"--}}
{{--                                               class="w-custom"></div>--}}
{{--                    <div class="mySlides"><img src="{{ asset('storage/assets/images/gallery_5.jpg') }}"--}}
{{--                                               class="w-custom"></div>--}}

{{--                    <a class="prev" onclick="plusSlides(-1)" style="color:#d83098">&#10094;</a>--}}
{{--                    <a class="next" onclick="plusSlides(1)" style="color:#d83098">&#10095;</a>--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <div style="text-align:center">--}}
{{--                    <span class="dot" onclick="currentSlide(1)"></span>--}}
{{--                    <span class="dot" onclick="currentSlide(2)"></span>--}}
{{--                    <span class="dot" onclick="currentSlide(3)"></span>--}}
{{--                    <span class="dot" onclick="currentSlide(4)"></span>--}}
{{--                    <span class="dot" onclick="currentSlide(5)"></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var date = new Date({{ $countdown }});
            Countdown.doCountdown(Countdown.format.home, 'time', date, false);
        });

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
    </script>
@endsection
