document.addEventListener('DOMContentLoaded', () => {
    const navToggle = document.querySelector('[data-nav-toggle]');
    const nav = document.querySelector('[data-nav]');

    if (navToggle && nav) {
        navToggle.addEventListener('click', () => nav.classList.toggle('is-open'));
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('[data-reveal]').forEach((element) => observer.observe(element));

    const bindImcPreview = (formSelector) => {
        const form = document.querySelector(formSelector);
        if (!form) return;

        const taille = form.querySelector('#taille');
        const poids = form.querySelector('#poids');
        const scope = form.closest('.tunnel-grid') || form.closest('.content-section') || form.closest('section') || document;
        const imcValue = scope.querySelector('[data-imc-value]');
        const imcLabel = scope.querySelector('[data-imc-label]');
        const imcFill = scope.querySelector('[data-imc-fill]') || document.querySelector('[data-imc-fill]');

        if (!taille || !poids || !imcValue || !imcLabel) return;

        const updateImc = () => {
            const tailleCm = parseFloat(taille.value);
            const poidsKg = parseFloat(poids.value);
            if (!tailleCm || !poidsKg) {
                imcValue.textContent = '--';
                imcLabel.textContent = 'Entrez votre taille et votre poids pour obtenir un apercu immediat.';
                if (imcFill) {
                    imcFill.style.width = '0%';
                    imcFill.dataset.zone = '';
                }
                return;
            }

            const tailleM = tailleCm / 100;
            const imc = poidsKg / (tailleM * tailleM);
            const boundedImc = Math.max(12, Math.min(imc, 40));
            const gaugePercent = ((boundedImc - 12) / 28) * 100;

            imcValue.textContent = imc.toFixed(1);

            if (imc < 18.5) {
                imcLabel.textContent = 'Zone basse: objectif prise de poids a envisager.';
                if (imcFill) imcFill.dataset.zone = 'low';
            } else if (imc <= 24.9) {
                imcLabel.textContent = 'Zone normale: base ideale pour un objectif equilibre.';
                if (imcFill) imcFill.dataset.zone = 'normal';
            } else if (imc <= 29.9) {
                imcLabel.textContent = 'Zone de surpoids: une reduction progressive peut etre conseillee.';
                if (imcFill) imcFill.dataset.zone = 'high';
            } else {
                imcLabel.textContent = 'Zone elevee: un programme encadre est recommande.';
                if (imcFill) imcFill.dataset.zone = 'very-high';
            }

            if (imcFill) {
                imcFill.style.width = `${gaugePercent}%`;
            }
        };

        ['input', 'change'].forEach((eventName) => {
            taille.addEventListener(eventName, updateImc);
            poids.addEventListener(eventName, updateImc);
        });

        updateImc();
    };

    bindImcPreview('[data-imc-form]');
    bindImcPreview('[data-diagnostic-form]');

    const goalForm = document.querySelector('[data-goal-form]');
    if (!goalForm) return;

    const cards = Array.from(goalForm.querySelectorAll('[data-goal-card]'));
    const targetField = goalForm.querySelector('[data-target-field]');
    const targetInput = targetField?.querySelector('input[name="target_kg"]');

    const updateGoalField = () => {
        const checked = goalForm.querySelector('input[name="objectif_id"]:checked');
        const activeCard = checked ? checked.closest('[data-goal-card]') : null;
        const type = activeCard?.dataset.goalType || '';

        cards.forEach((card) => card.classList.toggle('is-selected', card === activeCard));

        if (!targetField || !targetInput) return;

        const needsTarget = type === 'reduire' || type === 'augmenter';
        targetField.classList.toggle('is-hidden', !needsTarget);
        targetInput.required = needsTarget;

        if (!needsTarget) {
            targetInput.value = '';
        }
    };

    cards.forEach((card) => {
        const radio = card.querySelector('input[type="radio"]');
        card.addEventListener('click', () => {
            if (radio) {
                radio.checked = true;
                updateGoalField();
            }
        });
    });

    goalForm.querySelectorAll('input[name="objectif_id"]').forEach((input) => {
        input.addEventListener('change', updateGoalField);
    });

    updateGoalField();
});
