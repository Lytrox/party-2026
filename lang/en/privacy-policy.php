<?php

return [
    'title' => 'Privacy Policy',
    'subtitle' => 'Information on how we collect, use, and protect your personal data.',

    'sections' => [
        [
            'heading' => 'Who is Responsible',
            'body' => 'This website is operated as a private event platform for a birthday party. The person responsible for data processing under the GDPR is:',
            'items' => [
                'Berat Ari',
                'Contact: hello@lytrox.de',
            ],
        ],
        [
            'heading' => 'Account Data',
            'body' => 'When you register for an account, we collect the following data:',
            'items' => [
                'Displayed name',
                'Email address',
                'Password (stored as an irreversible hash — never in plain text)',
                'Preferred language',
            ],
        ],
        [
            'heading' => 'Party Registration Data',
            'body' => 'When you complete the party registration form, we additionally store:',
            'items' => [
                'Badge name (printed on your name badge at the event)',
                'Whether you are attending',
                'Dietary preferences (vegetarian, vegan)',
                'Allergy and intolerance information',
                'What you plan to bring',
                'Whether you will bring music equipment or a fursuit',
                'Whether you intend to drink alcohol',
            ],
        ],
        [
            'heading' => 'Session & Technical Data',
            'body' => 'To operate the platform securely, we store the following technical data in your session record:',
            'items' => [
                'IP address and browser information (user agent)',
                'Session activity timestamps',
                'If two-factor authentication is enabled: an encrypted TOTP secret and recovery codes',
            ],
        ],
        [
            'heading' => 'Cloudflare Turnstile',
            'body' => 'During login and registration, we use Cloudflare Turnstile as a CAPTCHA service to protect against automated abuse. Your IP address is transmitted to Cloudflare for verification. Cloudflare is based in the USA; data transfers are covered by the EU–US Data Privacy Framework.',
            'link' => ['label' => 'Cloudflare Privacy Policy', 'url' => 'https://www.cloudflare.com/privacypolicy/'],
        ],
        [
            'heading' => 'OpenStreetMap',
            'body' => 'The dashboard displays an embedded map from OpenStreetMap to show the party location. This map is loaded from OpenStreetMap\'s servers, which may receive your IP address and browser information as a result.',
            'link' => ['label' => 'OpenStreetMap Privacy Policy', 'url' => 'https://wiki.osmfoundation.org/wiki/Privacy_Policy'],
        ],
        [
            'heading' => 'Bunny Fonts',
            'body' => 'This website loads fonts via Bunny Fonts (fonts.bunny.net), a privacy-respecting alternative to Google Fonts. Bunny Fonts does not track users or share personal data.',
            'link' => ['label' => 'Bunny Fonts Privacy Policy', 'url' => 'https://bunny.net/privacy'],
        ],
        [
            'heading' => 'Email',
            'body' => 'We send transactional emails — such as email address verification and password resets — via a configured mail provider. Your email address is transmitted to this provider solely for delivery purposes.',
        ],
        [
            'heading' => 'Data Retention',
            'body' => 'Your data is stored for as long as your account exists or as long as it is required for organising the event. You may delete your account at any time via the account settings, which will permanently remove your personal data.',
        ],
        [
            'heading' => 'Your Rights',
            'body' => 'Under the GDPR, you have the following rights regarding your personal data:',
            'items' => [
                'Right of access — obtain a copy of the data we hold about you',
                'Right to rectification — correct inaccurate or incomplete data',
                'Right to erasure — request deletion of your data',
                'Right to restriction — limit how your data is processed',
                'Right to data portability — receive your data in a portable format',
                'Right to object — object to certain types of processing',
                'Right to lodge a complaint with a supervisory authority',
            ],
        ],
        [
            'heading' => 'Contact',
            'body' => 'For any privacy-related questions or to exercise your rights, please contact us at: hello@lytrox.de',
        ],
    ],
];
