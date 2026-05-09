document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('[data-profile-form]');
    if (!form) return;

    const alerts = document.querySelector('[data-profile-alerts]');
    const submitButton = form.querySelector('button[type="submit"]');
    const defaultButtonText = submitButton ? submitButton.textContent : '';
    const csrfInput = form.querySelector('#profile-csrf');

    const setAlert = function (message, type) {
        if (!alerts) return;
        alerts.innerHTML = message ? '<div class="alert-box alert-' + type + '">' + escapeHtml(message) + '</div>' : '';
    };

    const clearErrors = function () {
        form.querySelectorAll('[data-error-for]').forEach(function (errorNode) {
            errorNode.textContent = '';
        });
    };

    const showErrors = function (errors) {
        Object.keys(errors || {}).forEach(function (field) {
            const errorNode = form.querySelector('[data-error-for="' + field + '"]');
            if (errorNode) errorNode.textContent = errors[field];
        });
    };

    const updateCsrf = function (csrf) {
        if (csrfInput && csrf && csrf.name && csrf.hash) {
            csrfInput.name = csrf.name;
            csrfInput.value = csrf.hash;
        }
    };

    const updateProfileSummary = function (user) {
        if (!user) return;

        const nameNode = document.querySelector('[data-profile-name]');
        const topImcNode = document.querySelector('[data-profile-imc]');
        const previewImcNode = form.querySelector('[data-imc-value]');
        const headerUserNode = document.querySelector('.header-user span:first-child');

        if (nameNode && user.name) nameNode.textContent = user.name;
        if (headerUserNode && user.name) headerUserNode.textContent = user.name;
        if (topImcNode && user.imc) topImcNode.textContent = user.imc;
        if (previewImcNode && user.imc) previewImcNode.textContent = user.imc;
    };

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors();
        setAlert('', 'success');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Enregistrement...';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            const data = await response.json();

            updateCsrf(data.csrf);

            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }

            if (!response.ok || !data.success) {
                showErrors(data.errors);
                setAlert(data.message || 'La mise a jour a echoue.', 'danger');
                return;
            }

            form.querySelectorAll('input[type="password"]').forEach(function (input) {
                input.value = '';
            });
            updateProfileSummary(data.user);
            setAlert(data.message || 'Profil utilisateur mis a jour avec succes.', 'success');
        } catch (error) {
            setAlert('Impossible de contacter le serveur pour le moment.', 'danger');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = defaultButtonText;
            }
        }
    });

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
