// Admin Dashboard JS
document.addEventListener('DOMContentLoaded', function() {
    // Animation au démarrage
    animateStatCards();
    
    // Gestion du menu responsif
    initMobileMenu();
    
    // Tooltips
    initTooltips();
});

// Animer les cartes statistiques
function animateStatCards() {
    const cards = document.querySelectorAll('.stat-card, .stat-mini-card');
    cards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease ${index * 0.1}s both`;
    });
}

// Menu responsive
function initMobileMenu() {
    // Pas de menu toggle sur ce version, mais on peut ajouter plus tard si besoin
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const sidebar = document.querySelector('.admin-sidebar');
            if (sidebar) sidebar.style.display = 'flex';
        }
    });
}

// Initialiser les tooltips
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(el => {
        el.addEventListener('mouseenter', function() {
            showTooltip(this);
        });
        el.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });
}

function showTooltip(element) {
    const text = element.getAttribute('data-tooltip');
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = text;
    tooltip.style.position = 'absolute';
    tooltip.style.background = '#333';
    tooltip.style.color = '#fff';
    tooltip.style.padding = '8px 12px';
    tooltip.style.borderRadius = '6px';
    tooltip.style.fontSize = '12px';
    tooltip.style.whiteSpace = 'nowrap';
    tooltip.style.zIndex = '10000';
    tooltip.style.pointerEvents = 'none';
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 10) + 'px';
    tooltip.style.left = (rect.left + rect.width / 2 - tooltip.offsetWidth / 2) + 'px';
}

function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) tooltip.remove();
}

// Export de données en CSV
function exportToCSV(tableElement, fileName = 'export.csv') {
    let csv = [];
    const rows = tableElement.querySelectorAll('tr');
    
    rows.forEach(row => {
        let rowData = [];
        row.querySelectorAll('th, td').forEach(cell => {
            rowData.push('"' + cell.textContent.trim() + '"');
        });
        csv.push(rowData.join(','));
    });
    
    const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
    const link = document.createElement('a');
    link.setAttribute('href', encodeURI(csvContent));
    link.setAttribute('download', fileName);
    link.click();
}

// Imprimer une table
function printTable(tableElement) {
    const printWindow = window.open('', '', 'height=400,width=800');
    printWindow.document.write('<html><head><title>Impression</title>');
    printWindow.document.write('<link rel="stylesheet" href="' + window.location.origin + '/assets/css/admin-dashboard.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(tableElement.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Confirmer une action
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Afficher une notification
function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.padding = '12px 20px';
    notification.style.borderRadius = '8px';
    notification.style.zIndex = '10001';
    notification.style.animation = 'slideIn 0.3s ease';
    
    const typeColors = {
        success: { bg: 'rgba(39, 174, 96, 0.15)', color: '#27ae60' },
        error: { bg: 'rgba(231, 76, 60, 0.15)', color: '#e74c3c' },
        warning: { bg: 'rgba(243, 156, 18, 0.15)', color: '#f39c12' },
        info: { bg: 'rgba(52, 152, 219, 0.15)', color: '#3498db' }
    };
    
    const colors = typeColors[type] || typeColors.info;
    notification.style.background = colors.bg;
    notification.style.color = colors.color;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

// Formater les nombres
function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(num);
}

// Calculer IMC
function calculateIMC(poids, taille) {
    if (!poids || !taille) return 0;
    const tailleM = taille / 100;
    return Math.round((poids / (tailleM * tailleM)) * 10) / 10;
}

// Formater la date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// Animations CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Exporter les fonctions globales
window.Admin = {
    exportToCSV,
    printTable,
    confirmAction,
    showNotification,
    formatNumber,
    calculateIMC,
    formatDate
};
