/**
 * Validation email: vérifie que l'email se termine par @gmail.com
 */
function validateGmailFormat(email) {
    return /^[^\s@]+@gmail\.com$/.test(email);
}

/**
 * Affiche/masque un message de feedback
 */
function setEmailFeedback(inputElement, isValid, isGmail) {
    let feedback = document.getElementById('email-format-feedback');
    
    if (!feedback) {
        feedback = document.createElement('small');
        feedback.id = 'email-format-feedback';
        inputElement.insertAdjacentElement('afterend', feedback);
    }
    
    if (!inputElement.value.trim()) {
        feedback.style.display = 'none';
        return;
    }
    
    feedback.style.display = 'block';
    if (isGmail) {
        feedback.innerHTML = '<span class="field-hint-icon">✔</span> Format Gmail valide';
        feedback.className = 'field-hint hint-success';
    } else if (isValid) {
        feedback.innerHTML = '<span class="field-hint-icon">✕</span> Veuillez utiliser une adresse Gmail (@gmail.com)';
        feedback.className = 'field-hint hint-danger';
    } else {
        feedback.innerHTML = '<span class="field-hint-icon">✕</span> Adresse email invalide';
        feedback.className = 'field-hint hint-danger';
    }
}

/**
 * Affiche/masque un message de vérification des mots de passe
 */
function setPasswordMatchFeedback(passwordInput, confirmInput) {
    let feedback = document.getElementById('password-match-feedback');
    
    if (!feedback) {
        feedback = document.createElement('small');
        feedback.id = 'password-match-feedback';
        confirmInput.insertAdjacentElement('afterend', feedback);
    }
    
    const confirmValue = confirmInput.value.trim();
    
    if (!confirmValue) {
        feedback.style.display = 'none';
        return;
    }
    
    feedback.style.display = 'block';
    const passwordValue = passwordInput.value.trim();
    
    if (passwordValue === confirmValue && passwordValue.length > 0) {
        feedback.innerHTML = '<span class="field-hint-icon">✔</span> Les mots de passe correspondent';
        feedback.className = 'field-hint hint-success';
    } else {
        feedback.innerHTML = '<span class="field-hint-icon">✕</span> Les mots de passe ne correspondent pas';
        feedback.className = 'field-hint hint-danger';
    }
}

/**
 * Initialiser la validation des formulaires d'authentification
 */
document.addEventListener('DOMContentLoaded', function () {
    // Validation email Gmail pour la page d'inscription (step1)
    const registerEmailInput = document.querySelector('form[action*="register/step1"] input[name="email"]');
    if (registerEmailInput) {
        registerEmailInput.addEventListener('input', function () {
            const email = this.value.trim();
            const isValid = email.length > 0 && email.includes('@');
            const isGmail = validateGmailFormat(email);
            setEmailFeedback(this, isValid, isGmail);
        });
        
        // Validation au blur aussi
        registerEmailInput.addEventListener('blur', function () {
            setEmailFeedback(this, true, validateGmailFormat(this.value.trim()));
        });
    }

    // Validation des mots de passe pour la page d'inscription (step1)
    const registerPasswordInput = document.querySelector('form[action*="register/step1"] input[name="password"]');
    const registerConfirmInput = document.querySelector('form[action*="register/step1"] input[name="password_confirm"]');
    
    if (registerPasswordInput && registerConfirmInput) {
        registerConfirmInput.addEventListener('input', function () {
            setPasswordMatchFeedback(registerPasswordInput, this);
        });
        
        registerConfirmInput.addEventListener('blur', function () {
            setPasswordMatchFeedback(registerPasswordInput, this);
        });
    }

    // Validation email Gmail pour la page de connexion (login)
    const loginEmailInput = document.getElementById('login-email');
    if (loginEmailInput) {
        loginEmailInput.addEventListener('input', function () {
            const email = this.value.trim();
            const isValid = email.length > 0 && email.includes('@');
            const isGmail = validateGmailFormat(email);
            setEmailFeedback(this, isValid, isGmail);
        });
        
        loginEmailInput.addEventListener('blur', function () {
            setEmailFeedback(this, true, validateGmailFormat(this.value.trim()));
        });
    }

    // Empêcher la soumission du formulaire d'inscription si validation échoue
    const registerForm = document.querySelector('form[action*="register/step1"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            const email = registerEmailInput ? registerEmailInput.value.trim() : '';
            const password = registerPasswordInput ? registerPasswordInput.value.trim() : '';
            const confirmPassword = registerConfirmInput ? registerConfirmInput.value.trim() : '';
            
            const isEmailValid = validateGmailFormat(email);
            const arePasswordsMatching = password === confirmPassword && password.length > 0;
            
            if (!isEmailValid || !arePasswordsMatching) {
                event.preventDefault();
                if (!isEmailValid && registerEmailInput) {
                    setEmailFeedback(registerEmailInput, true, false);
                }
                if (!arePasswordsMatching && registerConfirmInput) {
                    setPasswordMatchFeedback(registerPasswordInput, registerConfirmInput);
                }
                return false;
            }
        });
    }

    // Empêcher la soumission du formulaire de connexion si validation échoue
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm && loginEmailInput) {
        loginForm.addEventListener('submit', function (event) {
            const email = loginEmailInput.value.trim();
            const isEmailValid = validateGmailFormat(email);
            
            if (!isEmailValid) {
                event.preventDefault();
                setEmailFeedback(loginEmailInput, true, false);
                return false;
            }
        });
    }
});
