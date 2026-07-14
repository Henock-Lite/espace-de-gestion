<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-transform="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>PharmaSys</title>
    <style>
        /* Resets de base obligatoires pour l'e-mailing */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background-color: #0f0f0f;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            box-sizing: border-box;
        }

        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a {
            text-decoration: none;
        }

        /* Media Queries pour le Mobile */
        @media only screen and (max-width: 480px) {
            .mobile-padding {
                padding: 24px 16px !important;
            }

            .mobile-btn-container {
                width: 100% !important;
                display: block !important;
            }

            .mobile-btn {
                display: block !important;
                padding: 14px 10px !important;
                font-size: 14px !important;
            }

            .mobile-title {
                font-size: 20px !important;
            }
        }
    </style>
</head>

<body
    style="margin: 0; padding: 0; background-color: #0f0f0f; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="background-color: #0f0f0f;">
        <tr>
            <td align="center" style="padding: 40px 10px;" class="mobile-padding">

                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" max-width="600"
                    style="max-width: 600px; width: 100%; background-color: #222222; border: 1px solid #333333; border-radius: 12px; overflow: hidden;">

                    <tr>
                        <td align="center" style="padding: 32px 32px 24px 32px; border-bottom: 1px solid #333333;"
                            class="mobile-padding">
                            <h1 class="mobile-title"
                                style="margin: 0; font-size: 24px; font-weight: 700; color: #a3e6c0; letter-spacing: -0.5px;">
                                PharmaSys</h1>
                            <p style="margin: 6px 0 0 0; font-size: 13px; color: #888888; font-weight: 500;">Système de
                                gestion de pharmacie</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 32px 32px;" class="mobile-padding">

                            @foreach ($introLines as $line)
                                <p style="margin: 0 0 16px 0; font-size: 14px; color: #aaaaaa; line-height: 1.6;">
                                    {{ $line }}</p>
                            @endforeach

                            @isset($actionText)
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"
                                    style="margin: 28px auto;" class="mobile-btn-container">
                                    <tr>
                                        <td align="center" style="border-radius: 999px; background-color: #3ecf8e;">
                                            <a href="{{ $actionUrl }}" class="mobile-btn"
                                                style="border: 1px solid #3ecf8e; border-radius: 999px; color: #111111; display: inline-block; font-size: 14px; font-weight: 600; padding: 14px 36px; text-decoration: none; mso-padding-alt: 0; text-align: center;">
                                                <span style="mso-text-raise: 10pt;">{{ $actionText }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endisset

                            @foreach ($outroLines as $line)
                                <p style="margin: 17px 0 16px 0; font-size: 14px; color: #aaaaaa; line-height: 1.6;">
                                    {{ $line }}
                                </p>
                            @endforeach
                            @isset($actionText)
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                    style="margin-top: 32px;">
                                    <tr>
                                        <td style="border-top: 1px solid #333333; padding-top: 24px;">
                                            <p
                                                style="margin: 0 0 8px 0; font-size: 12px; color: #666666; line-height: 1.4;">
                                                Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :
                                            </p>
                                            <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                                                width="100%"
                                                style="background-color: #1a1a1a; border: 1px solid #333333; border-radius: 8px;">
                                                <tr>
                                                    <td
                                                        style="padding: 12px 16px; font-size: 12px; color: #888888; word-break: break-all; line-height: 1.5;">
                                                        <a href="{{ $actionUrl }}"
                                                            style="color: #3ecf8e; text-decoration: none;">{{ $actionUrl }}</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endisset

                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="padding: 24px 32px; border-top: 1px solid #333333; background-color: #222222;"
                            class="mobile-padding">
                            <p style="margin: 0; font-size: 12px; color: #555555; line-height: 1.5;">
                                © {{ date('Y') }} <strong
                                    style="color: #3ecf8e; font-weight: 600;">PharmaSys</strong> — Tous droits réservés
                                Henock et collaborateurs Christian
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
