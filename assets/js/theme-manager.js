
document.addEventListener('DOMContentLoaded', function() {
    const ThemeManager = {
        init: function() {
            this.themeToggle = document.getElementById('themeToggle');
            this.htmlElement = document.documentElement;
            
            
            this.loadTheme();
            
            
            if(this.themeToggle) {
                this.themeToggle.addEventListener('click', this.toggleTheme.bind(this));
            }
            
            
            this.initSidebar();
        },
        
        loadTheme: function() {
            const savedTheme = this.getCookie('theme');
            if (savedTheme) {
                this.htmlElement.setAttribute('data-theme', savedTheme);
                this.updateThemeIcon(savedTheme);
            }
        },
        
        toggleTheme: function() {
            const currentTheme = this.htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            this.htmlElement.setAttribute('data-theme', newTheme);
            this.updateThemeIcon(newTheme);
            
            
            this.setCookie('theme', newTheme, 30);
        },
        
        updateThemeIcon: function(theme) {
            const icon = this.themeToggle.querySelector('i');
            if (theme === 'dark') {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            }
        },
        
        initSidebar: function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if(sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        },
        
        setCookie: function(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        },
        
        getCookie: function(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i=0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    };
    
    ThemeManager.init();
});