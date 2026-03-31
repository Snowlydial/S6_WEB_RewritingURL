<?php
    $pageTitle = 'Connexion';
    $extraCss  = ['login.css'];
    require __DIR__ . '/layout/head.php';
?>

<div class="login-page">

    <div class="login-panel--brand">
        <div>
            <div class="brand-title display">Iran<span class="brand-title__accent">Info</span></div>
            <p class="brand-tagline">Actualités &amp; analyses</p>
        </div>
        <div>
            <span class="accent-bar" style="margin-bottom:2rem"></span>
            <p style="font-family:var(--font-body);font-size:1.05rem;color:var(--grey);line-height:1.7;max-width:320px">
                Plateforme de gestion éditoriale.<br>
                Rédigez, publiez, et gérez le contenu depuis cet espace.
            </p>
        </div>
        <div class="brand-footer">
            <span class="accent-bar accent-bar--blue"></span>
            <span class="brand-footer__label">ETU003082 &mdash; ETU003224</span>
        </div>
    </div>

    <div class="login-panel--form">

        <div class="login-header">
            <h1>Connexion</h1>
        </div>

        <?php if (!empty($_GET['error'])): ?>
            <div class="error-msg" style="margin-bottom:1.5rem">
                Identifiants invalides. Veuillez réessayer.
            </div>
        <?php endif; ?>

        <form action="/login" method="post" class="login-form">
            <?= csrfField() ?>
            <div class="field">
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username"
                       placeholder="ex: admin" value="admin" required autofocus>
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••" value="admin" required>
            </div>
            <button type="submit" class="btn btn--primary">Se connecter</button>
        </form>

        <div class="login-divider"><span>ou</span></div>

        <a href="/fo/articles" class="guest-link">Continuer en tant qu'invite</a>

    </div>
</div>

</body>
</html>
