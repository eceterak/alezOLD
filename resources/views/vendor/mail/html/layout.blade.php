<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100%!important;
            }

            .footer {
                width: 100%!important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100%!important;
            }

            table {
                border-collapse: separate;
            }
            a, a:link {
                text-decoration: none;
            } 
            a:hover {
                text-decoration: none;
            }
            h2, h2 a, h3, h3 a, h4, h5, h6, .t_cht {
                color:#000!important;
            }
            .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {
                line-height: 100%;
            }
            .ExternalClass {
                width: 100%;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    {{ $header ?? '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="640" cellpadding="0" cellspacing="0">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                        <p class="help">Potrzebujesz pomocy? Skontaktuj sie z nami <a href="mailto:pomoc@alez.pl">pomoc@alez.pl</a></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
