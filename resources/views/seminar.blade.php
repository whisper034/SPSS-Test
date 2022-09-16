@extends('layouts.main')

@section('title','Seminar')

@section('site-content')

    @section('style')
        <style>
            .seminar-bg-1 {
                background-image: url("../storage/assets/images/Grafik_Bulat_1.png");
                background-size: calc(16vw + 200px);
                background-repeat: no-repeat;
                background-position-x: left;
                background-position-y: top;
            }

            .seminar-bg-2 {
                background-image: url("../storage/assets/images/Grafik_Bulat_2.png");
                background-size: calc(18vw + 160px);
                background-repeat: no-repeat;
                background-position-x: right;
                background-position-y: 45%;
            }

            .seminar-bg-3 {
                background-image: url("../storage/assets/images/Grafik_Bulat_3.png");
                background-size: calc(17vw + 160px);
                background-repeat: no-repeat;
                background-position-x: left;
                background-position-y: bottom;
            }

            .countdown {
                background-image: url("../storage/assets/images/Box_countdown.png");
                background-size: 100%;
                background-repeat: no-repeat;
            }

            .countdown-timer {
                padding: 18px 52px;
            }

            .wrapper {
                padding: 6vw 8vw;
            }

            .darkbluebox {
                padding: calc(3vw + 12px);
            }

            .penjelasan-header-content {
                line-height: 2;
            }

            #time {
                font-size: calc(24px + 2.5vw);
            }

            .penjelasan-countdown {
                margin: calc(24px + 4vw) 0;
            }

            .pembicara {
                width: 48%;
            }

            .section {
                display: flex;
                flex-direction: row;
            }

            .penjelasan-specification {
                width: 60%;
            }

            .penjelasan-benefit {
                margin-left: 5%;
                width: 35%;
            }

            .list {
                line-height: 1;
                display: flex;
                flex-direction: row;
            }

            .list-2 {
                line-height: 1;
                display: flex;
                flex-direction: row;
            }

            .btn-daftar {
                width: 90%;
                font-size: 24px;
            }

            .keterangan {
                width: 142px;
            }

            @media (max-width: 1050px) {
                .pembicara {
                    width: 68%;
                }

                .section {
                    flex-direction: column;
                }

                .penjelasan-specification {
                    width: 100%;
                }

                .penjelasan-benefit {
                    margin-left: 0%;
                    width: 100%;
                }
            }

            @media (max-width: 600px) {
                .pembicara {
                    width: 90%;
                }

                .list {
                    flex-direction: column;
                }

                .penjelasan-text {
                    margin-bottom: 12px;
                }

                .keterangan {
                    width: fit-content;
                }
            }
        </style>

    @endsection
    <div class="wrapper">
        <div class="text-white text-center">
            <div style="margin-bottom: 30px;">
                <span class="sub-heading" style="font-weight: bold;">
                    Webinar Online SPSS 2022
                </span>
            </div>
            <div style="font-size: 22px; margin-left: 20px; margin-right: 30px;">
                <p>
                    Webinar Online SPSS 2022 bertemakan "Inside the Mind of A Data Scientist: Tribute to the Country's Growth" akan membahas mengenai pentingnya peran data science bagi pengembangan ekonomi di Indonesia. Webinar ini akan dihadiri oleh pembicara yang berkompeten di bidang Data Science. Data scientist yang sangat diperlukan di Indonesia menjadi suatu dorongan bagi data scientist muda untuk dapat mengerti dan dapat mendalami apa saja tentang data science. Data scientist yang masih cenderung sedikit di Indonesia menjadi tolak ukur pembahasan topik ini.
                </p>
            </div>
        </div>

        <div class="text-white text-center" style="margin-top: 50px;">
            <div style="margin-bottom: 30px;">
                <span class="sub-heading" style="font-weight: bold;">
                    Benefit
                </span>
            </div>
            <div style="font-size: 22px;">
                <span>Poin SAT (khusus untuk Binusian), sertifikat elektronik, dan</span>
                <br>
                <span>tentunya <i>networking</i> serta ilmu baru bagi seluruh peserta</span>
                <br>
                <span>webinar. Selain itu, akana da door prize bagi peserta yang</span>
                <br>
                <span>beruntung.</span>
            </div>
        </div>

        <div class="darkbluebox" style="margin-top: 50px;">
            <div class="text-center">
                <img src="{{ asset('storage/assets/images/text bercahaya webinar.png') }}" alt="text-webinar" height="100px">
            </div>

            <div class="text-center text-white sub-heading" style="font-weight: bold; margin-top: 30px;">
                <span>"Inside the Mind of A Data Scientist: Tribute</span>
                <br>
                <span>to the Country's Growth"</span>
            </div>

            <div class="text-white text-center" style="margin-top: 40px;">
                <span class="countdown-timer" id="time" style="font-size: calc(60px + 1.5em); font-weight: bold;">00:00:00:00</span>
                <br>
                <span style="font-style: italic; font-size: 20px;">sebelum webinar dimulai</span>
            </div>

            <div class="seminar-grid" style="padding-top: 50px;">
                <div class="seminar-photo">
                </div>
                <div style="align-self: center;">
                    <div class="seminar-info text-white text-right">
                        <div class="">
                            <span class="heading">Sabtu, 01</span>
                            <br>
                            <span class="sub-heading">Oktober 2022</span>
                        </div>

                        <br>

                        <div class="">
                            <span class="heading">03:00 PM</span>
                            <br>
                            <span class="sub-heading">Waktu WIB</span>
                        </div>

                        <br>

                        <div class="">
                            <span class="heading">Pembicara</span>
                            <br>
                            <span class="sub-heading" style="font-weight: bold;">lorem ipsum pembicara</span>
                            <br>
                            <span class="sub-heading" style="font-style: italic;">lorem ipsum jabatan pembicara</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-white text-center" style="font-size: 30px; margin-top: 70px; font-weight: bold;">
                <span>Tidak dipungut biaya pendaftaran</span>
            </div>

            <div class="penjelasan-regist text-center" style="margin-bottom:calc(1vw + 20px); margin-top: 50px;">
                <a class="btn btn-outline-info btn-daftar" href="https://forms.gle/qeKcnJP2jerxbVbj9" target="_blank">Daftar</a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var date = new Date({{ $countdown }});
            Countdown.doCountdown(Countdown.format.home, 'time', date, false);
        });
    </script>
@endsection
