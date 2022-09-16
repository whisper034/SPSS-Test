<body style="box-sizing:border-box;margin:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,'Noto Sans',sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol','Noto Color Emoji';font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:left;background-color:#0b1026;">
    <div style="box-sizing:border-box;width:100%;padding-right:20px;padding-left:20px;margin-right:auto;margin-left:auto;color:white">
        <div style="box-sizing:border-box;text-align:center!important;margin:24px auto">
            <img src="{{ $message->embed(public_path('storage/assets/logos/logo-spss-with-theme.png')) }}" alt="" style="box-sizing:border-box;vertical-align:middle;border-style:none;width:50%">
        </div>
        @yield('mail-content')
    </div>
</body>
