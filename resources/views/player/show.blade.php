<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Visualitzador - {{ $screen->name }}</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background: #000;
            color: #fff;
            overflow: hidden;
        }

        #player {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            padding: 70px;
            background: linear-gradient(135deg, #111827, #1e3a8a);
        }

        .slide {
            max-width: 1200px;
            text-align: center;
        }

        .slide-type {
            display: inline-block;
            padding: 8px 18px;
            border: 2px solid white;
            border-radius: 999px;
            font-size: 22px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        h1 {
            font-size: 72px;
            margin: 0 0 32px 0;
            line-height: 1.1;
        }

        p {
            font-size: 38px;
            line-height: 1.35;
            margin: 0;
        }

        img {
            max-width: 70vw;
            max-height: 45vh;
            margin-top: 40px;
            border-radius: 20px;
        }

        .footer {
            position: fixed;
            bottom: 24px;
            left: 40px;
            right: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 22px;
            opacity: 0.85;
        }

        .blocked {
            background: #000 !important;
        }

        .blocked h1 {
            color: #fff;
        }

        .empty {
            background: #111 !important;
        }
    </style>
</head>
<body>
<div id="player">
    <div class="slide">
        <span class="slide-type">Carregant</span>
        <h1>Carregant contingut...</h1>
        <p>Espereu uns segons.</p>
    </div>
</div>

<div class="footer">
    <span>{{ $screen->name }}</span>
    <span id="clock"></span>
</div>

<script>
    const screenSlug = @json($screen->slug);
    const apiUrl = `/api/screens/${screenSlug}/content`;

    let slides = [];
    let currentIndex = 0;
    let intervalId = null;

    async function loadContent() {
        try {
            const response = await fetch(apiUrl, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.blocked) {
                showBlocked(data.message);
                return;
            }

            slides = data.slides || [];
            currentIndex = 0;

            if (slides.length === 0) {
                showEmpty();
                return;
            }

            showSlide();

            if (intervalId) {
                clearInterval(intervalId);
            }

            intervalId = setInterval(nextSlide, 8000);

        } catch (error) {
            showEmpty('No es pot carregar el contingut de la pantalla.');
        }
    }

    function showSlide() {
        const slide = slides[currentIndex];
        const player = document.getElementById('player');

        player.classList.remove('blocked', 'empty');

        const typeText = slide.type === 'web'
            ? 'Notícia web'
            : 'Comunicació interna';

        const imageHtml = slide.image_url
            ? `<img src="${escapeHtml(slide.image_url)}" alt="">`
            : '';

        player.innerHTML = `
            <div class="slide">
                <span class="slide-type">${typeText}</span>
                <h1>${escapeHtml(slide.title)}</h1>
                <p>${escapeHtml(slide.body || '')}</p>
                ${imageHtml}
            </div>
        `;
    }

    function nextSlide() {
        if (slides.length === 0) {
            return;
        }

        currentIndex = currentIndex + 1;

        if (currentIndex >= slides.length) {
            currentIndex = 0;
        }

        showSlide();
    }

    function showBlocked(message) {
        const player = document.getElementById('player');
        player.classList.add('blocked');

        player.innerHTML = `
            <div class="slide">
                <span class="slide-type">Fora de servei</span>
                <h1>${escapeHtml(message || 'Pantalla fora de servei')}</h1>
            </div>
        `;

        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    function showEmpty(message = 'No hi ha contingut disponible.') {
        const player = document.getElementById('player');
        player.classList.add('empty');

        player.innerHTML = `
            <div class="slide">
                <span class="slide-type">Sense contingut</span>
                <h1>${escapeHtml(message)}</h1>
            </div>
        `;

        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    function updateClock() {
        const now = new Date();

        document.getElementById('clock').textContent =
            now.toLocaleDateString('ca-ES') + ' ' +
            now.toLocaleTimeString('ca-ES');
    }

    function escapeHtml(text) {
        return String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    updateClock();
    setInterval(updateClock, 1000);

    loadContent();
    setInterval(loadContent, 60000);
</script>
</body>
</html>


