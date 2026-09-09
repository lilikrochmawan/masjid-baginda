<!-- Global Loader Component -->
<style>
    #global-loader {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.7); z-index: 99999;
        display: flex; justify-content: center; align-items: center;
        opacity: 0; visibility: hidden; transition: opacity 0.2s;
    }
    #global-loader.active { opacity: 1; visibility: visible; }
    .spinner {
        width: 50px; height: 50px; border: 5px solid #d1e7dd;
        border-top: 5px solid #10b981; border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    @media print { #global-loader { display: none !important; } }
</style>
<div id="global-loader"><div class="spinner"></div></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('global-loader');
        
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (this.target === '_blank') return;
                if (!this.checkValidity()) return;
                loader.classList.add('active');
            });
        });

        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (
                    e.ctrlKey || e.shiftKey || e.metaKey || 
                    this.target === '_blank' || 
                    !this.href || 
                    this.href.startsWith('javascript:') || 
                    this.href.startsWith('#') ||
                    this.hasAttribute('download')
                ) {
                    return;
                }
                loader.classList.add('active');
            });
        });
        
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                loader.classList.remove('active');
            }
        });
    });
</script>
