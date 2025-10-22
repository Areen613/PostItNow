document.addEventListener('DOMContentLoaded', function () {
    const langSelector = document.getElementById('languageSelector');
    if (langSelector) {
        langSelector.addEventListener('change', function () {
            const selectedLang = this.value;

            fetch('../handlers/SetLanguageHandler.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'lang=' + selectedLang
            })
                .then(response => response.text())
                .then(() => {
                    location.reload(); // Reload page to apply new language
                });
        });
    }
});
