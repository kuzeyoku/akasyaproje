    <div class="cookie-banner" id="cookieBanner">
        <div class="container">
            <div class="cookie-content">
                <div class="cookie-text">
                    <i class="fas fa-cookie-bite cookie-icon"></i>
                    <p class="cookie-message">
                        <strong>{{ setting('general', 'title') }}</strong> web sitemizde daha iyi hizmet verebilmek için
                        çerezler kullanıyoruz.
                        Sitemizi kullanmaya devam ederek çerez kullanımımızı kabul etmiş olursunuz.
                        <a href="#" style="color: #00ccdd; text-decoration: underline;">Gizlilik Politikası</a>
                    </p>
                </div>
                <div class="cookie-actions">
                    <button class="btn btn-accept" onclick="acceptCookies()">
                        <i class="fas fa-check me-2"></i>Kabul Et
                    </button>
                    <button class="btn btn-decline" onclick="declineCookies()">
                        <i class="fas fa-times me-2"></i>Reddet
                    </button>
                </div>
            </div>
        </div>
    </div>
