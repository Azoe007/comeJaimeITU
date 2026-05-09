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

    const form = document.querySelector('[data-imc-form]');
    if (!form) return;

    const taille = form.querySelector('#taille');
    const poids = form.querySelector('#poids');
    const imcValue = form.querySelector('[data-imc-value]');
    const imcLabel = form.querySelector('[data-imc-label]');

    const updateImc = () => {
        const tailleCm = parseFloat(taille.value);
        const poidsKg = parseFloat(poids.value);
        if (!tailleCm || !poidsKg) {
            imcValue.textContent = '--';
            imcLabel.textContent = 'Entrez votre taille et votre poids pour obtenir un apercu immediat.';
            return;
        }

        const tailleM = tailleCm / 100;
        const imc = poidsKg / (tailleM * tailleM);
        imcValue.textContent = imc.toFixed(1);

        if (imc < 18.5) {
            imcLabel.textContent = 'Zone basse: objectif prise de poids a envisager.';
        } else if (imc <= 24.9) {
            imcLabel.textContent = 'Zone ideale: maintien ou optimisation douce.';
        } else {
            imcLabel.textContent = 'Zone haute: objectif reduction de poids a envisager.';
        }
    };

    ['input', 'change'].forEach((eventName) => {
        taille.addEventListener(eventName, updateImc);
        poids.addEventListener(eventName, updateImc);
    });

    updateImc();
});
