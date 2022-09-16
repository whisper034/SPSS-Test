@extends('layouts.main')

@section('title','Home')

@section('site-content')

    @section('style')
        <style>
            .bluebox{
                margin:5vw;
            }
            .info{
                display: flex;
                flex-direction: row;
            }
            .info>p{
                line-height:1;
            }
            .img-tl{
                display:inline;
            }
            .img-tl2{
                display:none;
            }
            .img-tl3{
                display:none;
            }

            @media (max-width: 768px) {
                .bluebox{
                    padding:24px 14px;
                    display: flex;
                    flex-direction: column;
                }
                .summary-logo{
                    display:none;
                }
                .info{
                    flex-direction: column;
                    text-align: center;
                    font-size: 18px;
                }
                .heading{
                    font-size:36px;
                }
                .seminar-photo{
                    margin-top: 0px;
                    margin-bottom:28px;
                    width:220px;
                    height:220px;
                }
                .timeline-chart>img{
                    margin:0;
                    width:100%;
                }
                .img-tl{
                    display:none;
                }
                .img-tl2{
                    display:inline;
                }
                .img-tl3{
                    display:none;
                }
            }

            @media (max-width: 480px) {
                .img-tl{
                    display:none;
                }
                .img-tl2{
                    display:none;
                }
                .img-tl3{
                    display:inline;
                }
            }
        </style>
    @endsection

    <div class="container-fluid">
        <div class="summary bluebox">
            <div class="summary-text" style="margin-top: 0px;">
                <div style="text-align: left; margin-left: -30px;">
                    <img src="{{ asset('storage/assets/images/title home spss.png') }}" alt="title-home-spss" height="100px">
                </div>
                <br>
                <span class="sub-heading text-white" style="">Statistical Project for Smart Students</span>
                <p class="spss-info text-white">
                    SPSS atau Statistical Project for Smart Students adalah
                    acara berskala nasional yang diadakan oleh Himpunan
                    Mahasiswa Statistika (HIMSTAT) Binus University. SPSS
                    tahun ini bertemakan "Be the Foundation of Our Future
                    with Data Analytics". Tema tersebut dipilih mengingat
                    <i>data analyst</i> di Indonesia yang masih tergolong sedikit
                    dan kebutuhan <i>data analyst</i> yang semakin meningkat
                    kedepannya.
                </p>
            </div>
            <div class="summary-logo" style="text-align: center; margin-left: 60px;">
                <img src="{{ asset('storage/assets/logos/spss-logo-polos.png') }}">
{{--                <br>--}}
{{--                <span class="" style="font-size: 30px; color: #9ad7fb; font-weight: bold;">SPONSORED BY</span>--}}
            </div>
        </div>

{{--        <div class="seminar text-center bluebox">--}}
{{--            <div style="text-align: right;">--}}
{{--                <div style="margin-right: -25px;">--}}
{{--                    <img src="{{ asset('storage/assets/images/text home webinar.png') }}" alt="title-home-spss" height="100px">--}}
{{--                </div>--}}
{{--                <br>--}}
{{--                <span class="text-white sub-heading" style="margin-left: 450px; font-weight: bold;">"Inside the Mind of A Data Scientist: Tribute to the Country's Growth"</span>--}}
{{--            </div>--}}

{{--            <div class="seminar-grid">--}}
{{--                <div class="seminar-photo">--}}
{{--                </div>--}}
{{--                <div style="align-self: center;">--}}
{{--                    <div class="seminar-info text-white text-right">--}}
{{--                        <div class="">--}}
{{--                            <span class="heading">Sabtu, 01</span>--}}
{{--                            <br>--}}
{{--                            <span class="sub-heading">Oktober 2022</span>--}}
{{--                        </div>--}}

{{--                        <br>--}}

{{--                        <div class="">--}}
{{--                            <span class="heading">03:00 PM</span>--}}
{{--                            <br>--}}
{{--                            <span class="sub-heading">Waktu WIB</span>--}}
{{--                        </div>--}}

{{--                        <br>--}}

{{--                        <div class="">--}}
{{--                            <span class="heading">Pembicara</span>--}}
{{--                            <br>--}}
{{--                            <span class="sub-heading" style="font-weight: bold;">lorem ipsum pembicara</span>--}}
{{--                            <br>--}}
{{--                            <span class="sub-heading" style="font-style: italic;">lorem ipsum jabatan pembicara</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="" style="margin-top: 50px;">--}}
{{--                <a class="btn btn-outline-info fit-content-btn" href="/register" style="margin:0 5% 0 0; width:40%">Daftar</a>--}}
{{--                <a class="btn btn-outline-info fit-content-btn" href="/seminar" style="margin:0; width:40%">Informasi</a>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="timeline text-center bluebox">
            <div style="text-align: left;">
                <div>
                    <div style="margin-left: -30px;">
                        <img src="{{ asset('storage/assets/images/Lomba Statistika text bersinar.png') }}" alt="title-statistika-spss" height="100px">
                    </div>
                    <br>
                    <span class="sub-heading text-white" style="font-weight: bold;">Data 5.0 Mission: Probability Over Reality</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pendaftaran</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">17 September - 14 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Babak 1 (Penyisihan)</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">15 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumuman Babak 1</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">16 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Babak 2 (Semi Final)</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">17 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumuman Babak 2</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">21 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Final (Studi Kasus)</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">24 - 28 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Final (Presentasi)</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">5 November 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumuman Pemenang</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">5 November 2022</span>
                </div>
            </div>

            <br>

            <div class="buttons text-center">
                <a class="btn btn-outline-info fit-content-btn" href="/register" style="margin:0 5% 0 0; width:40%">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn" href="/lomba" style="margin:0; width:40%">Lebih lanjut</a>
            </div>
        </div>

        <div class="timeline text-center bluebox">
            <div style="text-align: right;">
                <div>
                    <div style="margin-right: -30px;">
                        <img src="{{ asset('storage/assets/images/Lomba essay text bersinar.png') }}" alt="title-essay-spss" height="100px">
                    </div>
                    <br>
                    <span class="sub-heading text-white" style="font-weight: bold;">Penggunaan Sains Data dalam Pengambilan Keputusan pada Industri di indonesia</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pendaftaran</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">25 September - 1 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumpulan</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">1 - 25 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumuman Pemenang</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">5 November 2022</span>
                </div>
            </div>

            <br>

            <div class="buttons text-center">
                <a class="btn btn-outline-info fit-content-btn" href="/register" style="margin:0 5% 0 0; width:40%">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn" href="/lomba" style="margin:0; width:40%">Lebih lanjut</a>
            </div>
        </div>

        <div class="timeline text-center bluebox">
            <div style="text-align: left;">
                <div>
                    <div style="margin-left: -20px;">
                        <img src="{{ asset('storage/assets/images/Lomba infografis.png') }}" alt="title-infografis-spss" height="100px">
                    </div>
                    <br>
                    <span class="sub-heading text-white" style="font-weight: bold;">Pentingnya Ilmu Statistika untuk Mempersiapkan Mahasiswa Mengahadapi Tantangan Revolusi Industri 5.0</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pendaftaran</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">20 September - 22 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumpulan</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">20 September - 22 Oktober 2022</span>
                </div>

                <br>

                <div>
                    <span class="heading-2 text-white">Pengumuman Pemenang</span>
                    <br>
                    <span class="sub-heading text-white" style="font-style: italic;">5 November 2022</span>
                </div>
            </div>

            <br>

            <div class="buttons text-center">
                <a class="btn btn-outline-info fit-content-btn" href="/register" style="margin:0 5% 0 0; width:40%">Daftar</a>
                <a class="btn btn-outline-info fit-content-btn" href="/lomba" style="margin:0; width:40%">Lebih lanjut</a>
            </div>
        </div>
    </div>

@endsection
