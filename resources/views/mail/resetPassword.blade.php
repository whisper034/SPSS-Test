@extends('layouts.mail')

@section('mail-content')
<table align="center" width="570" role="presentation" style="border-collapse:collapse;box-sizing:border-box;margin:0 auto;padding:0;width:570px;color:white;">
    <tbody>
        <tr style="box-sizing:border-box">
            <td style="box-sizing:border-box;max-width:100vw;padding:32px">
                <span>
                    <h1 style="margin-bottom:0.5rem;line-height:1.2;box-sizing:border-box;color:white;font-size:18px;font-weight:bold;margin-top:0;text-align:left">Halo!</h1>
                    <p style="margin-bottom:1rem;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                        Kami telah menerima permintaan anda untuk mengatur kembali kata sandi akun SPSS anda.
                    </p>
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%">
                        <tbody>
                            <tr style="box-sizing:border-box;">
                                <td align="center" style="box-sizing:border-box;">
                                    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;box-sizing:border-box;">
                                        <tbody>
                                            <tr style="box-sizing:border-box;">
                                                <td align="center" style="box-sizing:border-box;">
                                                    <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:collapse;box-sizing:border-box;">
                                                        <tbody>
                                                            <tr style="box-sizing:border-box;">
                                                                <td style="box-sizing:border-box;">
                                                                    <a href="{{ $url }}" style="box-sizing:border-box;border-radius:4px;color:#fff;display:inline-block;padding:0.375rem 0.75rem;overflow:hidden;text-decoration:none;border-bottom:1px solid #90CAFF;border-left:1px solid #90CAFF;border-right:1px solid #90CAFF;border-top:1px solid #90CAFF">Atur ulang kata sandi</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="margin-bottom:1rem;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                        Tautan untuk mengatur ulang kata sandi akan kadaluarsa dalam waktu {{ $count }} menit.
                    </p>
                    <p style="margin-bottom:1rem;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">
                        Jika anda tidak mengajukan pengaturan ulang kata sandi, abaikan pesan ini.
                        <br style="box-sizing:border-box">
                        Terima Kasih.
                    </p>
                </span>
            </td>
        </tr>
    </tbody>
</table>
@endsection