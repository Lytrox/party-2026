<?php

return [
    'title' => 'Datenschutzerklärung',
    'subtitle' => 'Informationen darüber, wie wir deine personenbezogenen Daten erheben, verwenden und schützen.',

    'sections' => [
        [
            'heading' => 'Verantwortliche Person',
            'body' => 'Diese Website wird als private Eventplattform für eine Geburtstagsparty betrieben. Die verantwortliche Person für die Datenverarbeitung im Sinne der DSGVO ist:',
            'items' => [
                'Berat Ari',
                'Kontakt: hello@lytrox.de',
            ],
        ],
        [
            'heading' => 'Kontodaten',
            'body' => 'Bei der Registrierung für ein Konto erheben wir folgende Daten:',
            'items' => [
                'Angezeigter Name',
                'E-Mail-Adresse',
                'Passwort (als nicht umkehrbarer Hash gespeichert – niemals im Klartext)',
                'Bevorzugte Sprache',
            ],
        ],
        [
            'heading' => 'Party-Anmeldedaten',
            'body' => 'Beim Ausfüllen des Party-Anmeldeformulars speichern wir zusätzlich:',
            'items' => [
                'Schildname (für dein Namensschild bei der Veranstaltung)',
                'Ob du teilnimmst',
                'Ernährungsweise (vegetarisch, vegan)',
                'Angaben zu Allergien und Unverträglichkeiten',
                'Was du mitbringen möchtest',
                'Ob du Musikequipment oder einen Fursuit mitbringst',
                'Ob du Alkohol trinken wirst',
            ],
        ],
        [
            'heading' => 'Sitzungs- und technische Daten',
            'body' => 'Zum sicheren Betrieb der Plattform speichern wir folgende technische Daten in deinem Sitzungsdatensatz:',
            'items' => [
                'IP-Adresse und Browser-Informationen (User-Agent)',
                'Zeitstempel der Sitzungsaktivität',
                'Bei aktivierter Zwei-Faktor-Authentifizierung: ein verschlüsseltes TOTP-Geheimnis und Wiederherstellungscodes',
            ],
        ],
        [
            'heading' => 'Cloudflare Turnstile',
            'body' => 'Bei Anmeldung und Registrierung nutzen wir Cloudflare Turnstile als CAPTCHA-Dienst zum Schutz vor automatisierten Zugriffen. Deine IP-Adresse wird zu diesem Zweck zur Verifizierung an Cloudflare übermittelt. Cloudflare hat seinen Sitz in den USA; Datenübertragungen sind durch das EU-US Data Privacy Framework abgedeckt.',
            'link' => ['label' => 'Datenschutzerklärung von Cloudflare', 'url' => 'https://www.cloudflare.com/privacypolicy/'],
        ],
        [
            'heading' => 'OpenStreetMap',
            'body' => 'Das Dashboard zeigt eine eingebettete Karte von OpenStreetMap zur Darstellung des Party-Standorts. Diese Karte wird von den Servern von OpenStreetMap geladen, wobei deine IP-Adresse und Browser-Informationen übermittelt werden können.',
            'link' => ['label' => 'Datenschutzerklärung von OpenStreetMap', 'url' => 'https://wiki.osmfoundation.org/wiki/Privacy_Policy'],
        ],
        [
            'heading' => 'Bunny Fonts',
            'body' => 'Diese Website lädt Schriftarten über Bunny Fonts (fonts.bunny.net), eine datenschutzfreundliche Alternative zu Google Fonts. Bunny Fonts verfolgt keine Nutzer und gibt keine personenbezogenen Daten weiter.',
            'link' => ['label' => 'Datenschutzerklärung von Bunny Fonts', 'url' => 'https://bunny.net/privacy'],
        ],
        [
            'heading' => 'E-Mail',
            'body' => 'Wir versenden transaktionale E-Mails – etwa zur E-Mail-Verifizierung und zum Passwort-Reset – über einen konfigurierten Mail-Anbieter. Deine E-Mail-Adresse wird ausschließlich zur Zustellung an diesen Anbieter übermittelt.',
        ],
        [
            'heading' => 'Speicherdauer',
            'body' => 'Deine Daten werden gespeichert, solange dein Konto besteht oder solange sie für die Organisation der Veranstaltung erforderlich sind. Du kannst dein Konto jederzeit über die Kontoeinstellungen löschen, wodurch deine personenbezogenen Daten dauerhaft entfernt werden.',
        ],
        [
            'heading' => 'Deine Rechte',
            'body' => 'Gemäß der DSGVO hast du folgende Rechte bezüglich deiner personenbezogenen Daten:',
            'items' => [
                'Auskunftsrecht – Erhalt einer Kopie der über dich gespeicherten Daten',
                'Recht auf Berichtigung – Korrektur unrichtiger oder unvollständiger Daten',
                'Recht auf Löschung – Anforderung der Löschung deiner Daten',
                'Recht auf Einschränkung – Begrenzung der Verarbeitung deiner Daten',
                'Recht auf Datenübertragbarkeit – Erhalt deiner Daten in einem portablen Format',
                'Widerspruchsrecht – Widerspruch gegen bestimmte Arten der Verarbeitung',
                'Recht auf Beschwerde bei einer Datenschutzbehörde',
            ],
        ],
        [
            'heading' => 'Kontakt',
            'body' => 'Bei datenschutzbezogenen Fragen oder zur Ausübung deiner Rechte wende dich bitte an: hello@lytrox.de',
        ],
    ],
];
