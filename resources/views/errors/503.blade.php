<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="color-scheme: dark;">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ __('Under Maintenance') }} &mdash; {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: #27272a;
            color: #f4f4f5;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .card {
            text-align: center;
            max-width: 28rem;
            width: 100%;
        }

        .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background-color: #3f3f46;
            margin-bottom: 1.5rem;
        }

        .icon svg {
            width: 1.75rem;
            height: 1.75rem;
            color: #a1a1aa;
        }

        h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #f4f4f5;
            margin-bottom: 0.625rem;
        }

        p {
            font-size: 0.9375rem;
            color: #a1a1aa;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .reload-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 500;
            color: #f4f4f5;
            background-color: #3f3f46;
            border: 1px solid #52525b;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .reload-btn:hover { background-color: #52525b; }

        .countdown {
            display: block;
            margin-top: 1.25rem;
            font-size: 0.8125rem;
            color: #71717a;
        }
    </style>
    <script>
        var seconds = 30;
        var singular = @json(__('Automatically reloading in :seconds second…|Automatically reloading in :seconds seconds…', ['seconds' => '[[s]]']));
        var plural   = @json(trans_choice('Automatically reloading in :seconds second…|Automatically reloading in :seconds seconds…', 2, ['seconds' => '[[s]]']));

        function tick() {
            seconds--;
            var tpl = seconds === 1 ? singular : plural;
            var el = document.getElementById('countdown');
            if (el) { el.textContent = tpl.replace('[[s]]', seconds); }
            if (seconds <= 0) { location.reload(); } else { setTimeout(tick, 1000); }
        }
        document.addEventListener('DOMContentLoaded', function () { setTimeout(tick, 1000); });
    </script>
</head>
<body>
    <div class="card">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l5.654-4.654m5.894-4.01a2.25 2.25 0 0 1 2.12 2.44l-.318 2.63a2.25 2.25 0 0 1-.643 1.433l-4.207 4.207" />
            </svg>
        </div>

        <h1>{{ __('Under Maintenance') }}</h1>

        <p>{!! nl2br(e(__(':app is currently undergoing maintenance. Please try again in a couple of seconds.', ['app' => config('app.name', 'Laravel')]))) !!}</p>

        <button class="reload-btn" onclick="location.reload()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            {{ __('Reload page') }}
        </button>

        <span class="countdown" id="countdown">
            {{ trans_choice('Automatically reloading in :seconds second…|Automatically reloading in :seconds seconds…', 30, ['seconds' => 30]) }}
        </span>
    </div>
</body>
</html>
