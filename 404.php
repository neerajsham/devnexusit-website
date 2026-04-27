<?php include 'header.php'; ?>
<style>
    .error-404-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .error-content {
        text-align: center;
        animation: fadeInUp 0.8s ease;
    }

    .error-code {
        position: relative;
        margin-bottom: 20px;
    }

    .error-code h1 {
        font-size: 180px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1;
        position: relative;
        z-index: 2;
    }

    .error-shape {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.05) 100%);
        border-radius: 50%;
        z-index: 1;
    }

    .error-content h2 {
        font-size: 36px;
        color: #2d3748;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .error-content p {
        font-size: 18px;
        color: #718096;
        margin-bottom: 40px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .error-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-home, .btn-quote {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-home {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102,126,234,0.4);
    }

    .btn-quote {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
    }

    .btn-quote:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-3px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .error-code h1 {
            font-size: 120px;
        }
        
        .error-content h2 {
            font-size: 28px;
        }
        
        .error-content p {
            font-size: 16px;
            padding: 0 20px;
        }
        
        .btn-home, .btn-quote {
            padding: 12px 24px;
            font-size: 14px;
        }
    }
</style>
<!-- Main 404 Section -->
<main class="error-404-section">
    <div class="container">
        <div class="error-content">
            <div class="error-code">
                <h1>404</h1>
                <div class="error-shape"></div>
            </div>
            <h2>Oops! Page Not Found</h2>
            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <div class="error-buttons">
                <a href="/" class="btn-home">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <!--<a href="/request-quote" class="btn-quote">-->
                <!--    <i class="fas fa-file-invoice"></i> Request for Quote-->
                <!--</a>-->
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>