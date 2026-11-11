(function () {
    var registry = [];

    function applyFrame(container, html) {
        if (!container) {
            return;
        }
        container.style.opacity = '0.35';
        window.setTimeout(function () {
            container.innerHTML = html;
            container.style.opacity = '1';
        }, 180);
    }

    function msUntilNextBoundary(intervalSec) {
        var intervalMs = Math.max(10, parseInt(intervalSec, 10) || 30) * 1000;
        var now = Date.now();
        return intervalMs - (now % intervalMs);
    }

    function startRotator(entry) {
        if (!entry || !entry.frames || entry.frames.length <= 1) {
            return;
        }
        entry.index = 0;

        function advance() {
            entry.index = (entry.index + 1) % entry.frames.length;
            applyFrame(entry.container, entry.frames[entry.index]);
        }

        // 절대시간 경계(예: 30분)에 맞춰 다음 세트로 교체
        window.setTimeout(function () {
            advance();
            entry.timer = window.setInterval(advance, entry.intervalMs);
        }, msUntilNextBoundary(entry.intervalSec));
    }

    window.pkshopPromoRotateRegister = function (containerId, frames, intervalSec) {
        var container = document.getElementById(containerId);
        if (!container || !frames || frames.length <= 1) {
            return;
        }
        var sec = Math.max(10, parseInt(intervalSec, 10) || 30);
        registry.push({
            container: container,
            frames: frames,
            intervalSec: sec,
            intervalMs: sec * 1000,
            index: 0
        });
    };

    function initAll() {
        var nodes = document.querySelectorAll('.pkshop-promo-rotate');
        for (var i = 0; i < nodes.length; i++) {
            nodes[i].style.transition = 'opacity 0.35s ease';
        }
        for (var j = 0; j < registry.length; j++) {
            startRotator(registry[j]);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
