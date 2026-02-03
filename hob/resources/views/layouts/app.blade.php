<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php use App\Models\Conversation; @endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>FindStay</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS Variables for Design System */
        :root {
            /* Color Palette - Preserving existing colors */
            --primary-dark: #244F76;
            --primary-light: #7C9FC0;
            --primary-lighter: #d1dbe6;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
            
            /* Spacing System - 8px grid */
            --spacing-xs: 0.5rem;   /* 8px */
            --spacing-sm: 1rem;     /* 16px */
            --spacing-md: 1.5rem;   /* 24px */
            --spacing-lg: 2rem;     /* 32px */
            --spacing-xl: 3rem;     /* 48px */
            --spacing-2xl: 4rem;    /* 64px */
            
            /* Border Radius Scale */
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 20px;
            --radius-full: 50%;
            
            /* Shadow Hierarchy */
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.15);
            --shadow-colored: 0 10px 30px rgba(124, 159, 192, 0.3);
            
            /* Transitions */
            --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-bounce: 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            
            /* Typography Scale */
            --font-xs: 0.75rem;
            --font-sm: 0.875rem;
            --font-base: 1rem;
            --font-lg: 1.125rem;
            --font-xl: 1.25rem;
            --font-2xl: 1.5rem;
            --font-3xl: 1.875rem;
            --font-4xl: 2.25rem;
            
            /* Line Heights */
            --leading-tight: 1.25;
            --leading-normal: 1.5;
            --leading-relaxed: 1.75;
        }
        
        /* Global Base Styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            background: var(--white) !important;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Inknut Antiqua', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: var(--leading-normal);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Enhanced Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: var(--leading-tight);
            margin-bottom: var(--spacing-md);
            color: var(--primary-dark);
        }
        
        h1 { font-size: var(--font-4xl); }
        h2 { font-size: var(--font-3xl); }
        h3 { font-size: var(--font-2xl); }
        h4 { font-size: var(--font-xl); }
        h5 { font-size: var(--font-lg); }
        h6 { font-size: var(--font-base); }
        
        p {
            margin-bottom: var(--spacing-md);
            color: var(--text-dark);
        }
        
        /* Enhanced Button Styles */
        .btn {
            border-radius: var(--radius-lg);
            font-weight: 600;
            padding: var(--spacing-sm) var(--spacing-lg);
            transition: all var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
            text-transform: none;
            letter-spacing: 0.01em;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left var(--transition-slow);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-secondary {
            background: var(--white);
            color: var(--primary-dark);
            border: 2px solid var(--primary-lighter);
        }
        
        .btn-secondary:hover {
            background: var(--primary-lighter);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        /* Enhanced Form Controls */
        .form-control, .form-select {
            border: 2px solid var(--primary-lighter);
            border-radius: var(--radius-lg);
            padding: var(--spacing-sm) var(--spacing-md);
            transition: all var(--transition);
            font-size: var(--font-base);
            background: var(--white);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.2rem rgba(124, 159, 192, 0.25);
            outline: none;
            transform: translateY(-1px);
        }
        
        .form-control:hover, .form-select:hover {
            border-color: var(--primary-light);
        }
        
        /* Enhanced Cards */
        .card {
            border: none;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
            transition: all var(--transition);
            overflow: hidden;
            background: var(--white);
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: var(--spacing-lg);
            font-weight: 600;
        }
        
        /* Enhanced Alerts */
        .alert {
            border: none;
            border-radius: var(--radius-lg);
            padding: var(--spacing-md) var(--spacing-lg);
            margin-bottom: var(--spacing-md);
            box-shadow: var(--shadow-sm);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid var(--success);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid var(--danger);
        }
        
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            border-left: 4px solid var(--info);
        }
        
        /* Enhanced Navigation */
        .navbar,
        .navbar-custom,
        .navbar-expand-lg {
            box-shadow: none !important;
        }
        
        .main-header-bg {
            background: url('/images/image.png') center/cover no-repeat;
            min-height: 220px;
            position: relative;
        }
        
        .navbar-custom {
            background: transparent !important;
            backdrop-filter: none;
            border-radius: 0;
            position: relative;
            z-index: 2;
        }
        
        .navbar-brand img {
            height: 150px;
            background: none !important;
            box-shadow: none !important;
            transition: transform var(--transition-bounce);
        }
        
        .navbar-brand img:hover {
            transform: scale(1.10) rotate(-2deg);
        }
        
        .navbar-custom .nav-link, 
        .navbar-custom .fa, 
        .navbar-custom .fas, 
        .navbar-custom .far, 
        .navbar-custom .dropdown-toggle {
            color: var(--primary-dark) !important;
            font-weight: 600;
            font-size: var(--font-lg);
            position: relative;
            transition: color var(--transition);
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: var(--radius-md);
        }
        
        .navbar-custom .nav-link::after {
            content: '';
            display: block;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
            transition: width var(--transition-bounce);
            position: absolute;
            left: 50%;
            bottom: 0;
            border-radius: var(--radius-sm);
            transform: translateX(-50%);
        }
        
        .navbar-custom .nav-link:hover::after, 
        .navbar-custom .nav-link.active::after {
            width: 80%;
        }
        
        .navbar-custom .nav-link:hover {
            color: var(--primary-light) !important;
            background: rgba(124, 159, 192, 0.1);
        }
        
        .navbar-custom .nav-link.active {
            color: var(--primary-light) !important;
        }
        
        /* Enhanced Header Welcome */
        .header-welcome {
            position: absolute;
            left: 50%;
            top: 60%;
            transform: translate(-50%, -50%);
            color: var(--primary-dark);
            font-size: var(--font-4xl);
            font-weight: 700;
            text-shadow: 2px 2px 12px rgba(255, 255, 255, 0.8);
            z-index: 2;
            animation: fadeInUp 1.1s var(--transition-bounce);
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translate(-50%, 30px); 
            }
            to { 
                opacity: 1; 
                transform: translate(-50%, -50%); 
            }
        }
        
        /* Enhanced Main Content */
        .main-content {
            flex: 1 0 auto;
            padding-bottom: var(--spacing-2xl);
        }
        
        /* Enhanced Footer */
        .footer-custom {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: var(--white);
            padding: var(--spacing-xl) 0 var(--spacing-lg) 0;
            font-size: var(--font-base);
            border-top: 1px solid var(--primary-lighter);
            position: relative;
            overflow: hidden;
        }
        
        .footer-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        
        .footer-custom .footer-logo {
            height: 150px;
            margin-bottom: var(--spacing-md);
            transition: transform var(--transition-bounce);
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        }
        
        .footer-custom .footer-logo:hover {
            transform: scale(1.10) rotate(-2deg);
        }
        
        .footer-custom a {
            color: var(--white);
            text-decoration: none;
            transition: all var(--transition);
            position: relative;
        }
        
        .footer-custom a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--white);
            transition: width var(--transition);
        }
        
        .footer-custom a:hover {
            color: rgba(255, 255, 255, 0.8);
            transform: translateY(-1px);
        }
        
        .footer-custom a:hover::after {
            width: 100%;
        }
        
        .footer-custom .footer-section {
            margin-bottom: var(--spacing-lg);
        }
        
        .footer-custom .footer-title {
            font-weight: 700;
            margin-bottom: var(--spacing-md);
            font-size: var(--font-lg);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .footer-custom .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-custom .footer-links li {
            margin-bottom: var(--spacing-sm);
        }
        
        .footer-custom .footer-links a {
            padding: var(--spacing-xs) 0;
            display: block;
            border-radius: var(--radius-sm);
            transition: all var(--transition);
        }
        
        .footer-custom .footer-links a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: var(--spacing-sm);
        }
        
        .footer-custom .footer-bottom {
            text-align: center;
            font-size: var(--font-sm);
            margin-top: var(--spacing-lg);
            color: rgba(255, 255, 255, 0.8);
            padding-top: var(--spacing-lg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Enhanced Dropdowns */
        .dropdown-menu {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            padding: var(--spacing-sm);
            background: var(--white);
            animation: dropdownFadeIn var(--transition);
        }
        
        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-menu-messages {
            min-width: 320px;
            max-width: 350px;
        }
        
        .dropdown-menu-notifications {
            min-width: 350px;
            max-width: 400px;
        }
        
        .dropdown-item {
            border-radius: var(--radius-md);
            padding: var(--spacing-sm) var(--spacing-md);
            transition: all var(--transition);
            margin-bottom: var(--spacing-xs);
        }
        
        .dropdown-item:hover {
            background: var(--primary-lighter);
            color: var(--primary-dark);
            transform: translateX(4px);
        }
        
        .notif-item {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            color: var(--white);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-sm);
            padding: var(--spacing-sm);
            display: flex;
            align-items: center;
            transition: all var(--transition);
            cursor: pointer;
        }
        
        .notif-item:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-colored);
        }
        
        .notif-item .notif-avatar {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-full);
            object-fit: cover;
            margin-right: var(--spacing-sm);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .notif-item .notif-content {
            flex: 1;
        }
        
        .notif-item .notif-name {
            font-weight: 700;
            font-size: var(--font-base);
            margin-bottom: var(--spacing-xs);
        }
        
        .notif-item .notif-role {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border-radius: var(--radius-md);
            font-size: var(--font-xs);
            padding: 2px var(--spacing-sm);
            margin-left: var(--spacing-sm);
            font-weight: 600;
        }
        
        .notif-item .notif-message {
            font-size: var(--font-sm);
            opacity: 0.9;
            line-height: var(--leading-tight);
        }
        
        .dropdown-header {
            font-size: var(--font-lg);
            font-weight: 700;
            color: var(--primary-dark);
            padding: var(--spacing-sm) var(--spacing-md);
            border-bottom: 2px solid var(--primary-lighter);
            margin-bottom: var(--spacing-sm);
        }
        
        .dropdown-menu-messages .dropdown-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            padding: var(--spacing-sm) var(--spacing-md);
            transition: all var(--transition);
        }
        
        .dropdown-menu-messages .dropdown-item img {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 2px solid var(--primary-lighter);
        }
        
        .dropdown-menu-messages .dropdown-item span {
            font-size: var(--font-base);
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .dropdown-menu-messages .dropdown-item:not(:last-child) {
            border-bottom: 1px solid var(--primary-lighter);
        }
        
        .dropdown-menu-messages .dropdown-item:hover {
            background: var(--primary-lighter);
            transform: translateX(4px);
        }
        
        /* Enhanced Badges */
        .badge {
            font-weight: 600;
            font-size: var(--font-xs);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-full);
            letter-spacing: 0.025em;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, var(--danger) 0%, #c82333 100%) !important;
            min-width: 20px;
            min-height: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Enhanced Modals */
        .modal-lg {
            max-width: 700px;
        }
        
        .modal-content {
            max-height: 80vh;
            overflow: hidden;
            border: none;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            padding: var(--spacing-lg);
        }
        
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
            padding: var(--spacing-lg);
        }
        
        .modal-footer {
            border: none;
            padding: var(--spacing-lg);
            background: var(--white);
        }
        
        /* Enhanced Chat Box */
        #chatBoxContainer {
            position: fixed;
            top: 80px;
            right: 0;
            width: 340px;
            height: 500px;
            background: var(--white);
            box-shadow: var(--shadow-xl);
            border-top-left-radius: var(--radius-xl);
            border-bottom-left-radius: var(--radius-xl);
            z-index: 1055;
            display: flex;
            flex-direction: column;
            transition: all var(--transition);
            transform: translateX(0);
        }
        
        #chatBoxContainer.minimized {
            transform: translateX(300px);
        }
        
        #chatBoxContainer .chat-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
            color: var(--white);
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 var(--spacing-md);
            border-top-left-radius: var(--radius-xl);
            font-size: var(--font-base);
            font-weight: 700;
            justify-content: space-between;
            cursor: pointer;
        }
        
        #chatBoxContainer .chat-header:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
        }
        
        #chatBoxContainer .chat-header img {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-full);
            margin-right: var(--spacing-sm);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Enhanced Loading States */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--primary-lighter);
            border-radius: var(--radius-full);
            border-top-color: var(--primary-light);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Enhanced Professional Cards */
        .professional-card {
            background: linear-gradient(135deg, var(--white) 0%, #f8f9fa 100%);
            border: none;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-md);
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .professional-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
        }
        
        .professional-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }
        
        /* Enhanced Section Titles */
        .section-title {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            position: relative;
            text-align: center;
            font-size: var(--font-3xl);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -var(--spacing-sm);
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-light), var(--primary-dark));
            border-radius: var(--radius-sm);
        }
        
        /* Enhanced Custom Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: var(--radius-xl);
            font-weight: 600;
            padding: var(--spacing-md) var(--spacing-xl);
            font-size: var(--font-lg);
            transition: all var(--transition);
            color: var(--white);
            position: relative;
            overflow: hidden;
            text-transform: none;
            letter-spacing: 0.01em;
        }
        
        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left var(--transition-slow);
        }
        
        .btn-primary-custom:hover::before {
            left: 100%;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        }
        
        .btn-primary-custom:active {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        
        /* Enhanced Form Labels */
        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: var(--spacing-xs);
            font-size: var(--font-sm);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        /* Enhanced Error Messages */
        .text-danger {
            color: var(--danger) !important;
            font-weight: 500;
            font-size: var(--font-sm);
        }
        
        /* Enhanced Success Messages */
        .text-success {
            color: var(--success) !important;
            font-weight: 500;
        }
        
        /* Responsive Enhancements */
        @media (max-width: 768px) {
            .header-welcome {
                font-size: var(--font-2xl);
            }
            
            #chatBoxContainer {
                width: 100%;
                height: 400px;
                border-radius: 0;
            }
            
            .professional-card {
                margin-bottom: var(--spacing-md);
            }
            
            .btn-primary-custom {
                padding: var(--spacing-sm) var(--spacing-lg);
                font-size: var(--font-base);
            }
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Enhanced Focus States */
        *:focus {
            outline: none;
        }
        
        *:focus-visible {
            outline: 2px solid var(--primary-light);
            outline-offset: 2px;
        }
        
        /* Enhanced Selection */
        ::selection {
            background: var(--primary-light);
            color: var(--white);
        }
        
        /* Enhanced Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--primary-lighter);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: var(--radius-sm);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
        }
        .notif-item .notif-content {
            flex: 1;
        }
        .notif-item .notif-name {
            font-weight: bold;
            font-size: 1rem;
        }
        .notif-item .notif-role {
            background: #e3f2fd;
            color: #24507a;
            border-radius: 8px;
            font-size: 0.8rem;
            padding: 2px 8px;
            margin-left: 8px;
        }
        .notif-item .notif-message {
            font-size: 0.95rem;
        }
        .dropdown-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #24507a;
        }
        .dropdown-menu-messages .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
        }
        .dropdown-menu-messages .dropdown-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .dropdown-menu-messages .dropdown-item span {
            font-size: 1rem;
            font-weight: 500;
        }
        .dropdown-menu-messages .dropdown-item:not(:last-child) {
            border-bottom: 1px solid #f0f0f0;
        }
        .badge.bg-danger {
            font-size: 0.8rem;
            min-width: 20px;
            min-height: 20px;
        }
        .modal-lg {
            max-width: 700px;
        }
        .modal-content {
            max-height: 80vh;
            overflow: hidden;
        }
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
        #chatBoxContainer {
            position: fixed;
            top: 80px; /* below navbar */
            right: 0;
            width: 340px;
            height: 500px;
            background: #fff;
            box-shadow: -2px 0 16px rgba(36,80,122,0.12);
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            z-index: 1055;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }
        #chatBoxContainer .chat-header {
            background: #24507a;
            color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            border-top-right-radius: 16px;
            font-size: 16px;
            font-weight: bold;
            justify-content: space-between;
        }
        #chatBoxContainer .chat-header img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }
        #chatBoxContainer .close-chat-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 22px;
            cursor: pointer;
        }
        #chatBoxContainer .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 12px;
            background: #f8f9fa;
        }
        #chatBoxContainer .chat-message {
            max-width: 250px;
            padding: 10px 12px;
            margin-bottom: 10px;
            border-radius: 15px;
            font-size: 14px;
            word-break: break-word;
        }
        #chatBoxContainer .chat-message.sent {
            background: #24507a;
            color: #fff;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }
        #chatBoxContainer .chat-message.received {
            background: #e9ecef;
            color: #222;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }
        #chatBoxContainer .message-time {
            font-size: 0.75em;
            color: #888;
            margin-top: 2px;
            text-align: right;
        }
        #chatBoxContainer .chat-footer {
            height: 50px;
            padding: 8px 10px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            align-items: center;
            border-bottom-right-radius: 16px;
        }
        #chatBoxContainer .chat-footer .input-group {
            width: 100%;
        }
        #chatBoxContainer .chat-footer input {
            font-size: 14px;
        }
        #chatBoxContainer .chat-footer button {
            font-size: 20px;
        }
        /* Ensure dropdown icons and toggles are always #244F76 */
        .navbar-custom .dropdown-toggle::after {
            color: #244F76 !important;
        }
        .navbar-custom .dropdown-menu {
            min-width: 320px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(36,79,118,0.08);
            border: 1px solid #eaf1f7;
        }
        .navbar-custom .dropdown-menu .dropdown-header {
            color: #244F76;
        }
        .navbar-custom .dropdown-item {
            color: #244F76;
        }
        .navbar-custom .dropdown-item:hover, .navbar-custom .dropdown-item:focus {
            background: #eaf1f7;
            color: #244F76;
        }
        /* Icon animations */
        .navbar-custom .fa-cog:hover {
            animation: spinCog 0.7s cubic-bezier(.68,-0.55,.27,1.55);
        }
        @keyframes spinCog {
            0% { transform: rotate(0deg); }
            60% { transform: rotate(180deg); }
            100% { transform: rotate(360deg); }
        }
        .navbar-custom .fa-bell[data-has-unread="true"] {
            animation: bellPulse 1.2s infinite alternate;
        }
        @keyframes bellPulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.15) rotate(-8deg); }
        }
        .mark-read-btn {
            background: #fff !important;
            color: #244F76 !important;
            border: 1.5px solid #244F76 !important;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, color 0.2s;
        }
        .mark-read-btn i {
            color: #244F76 !important;
        }
        .mark-read-btn:hover {
            background: #244F76 !important;
            color: #fff !important;
        }
        .mark-read-btn:hover i {
            color: #fff !important;
        }

        /* ========================================
           RESPONSIVE DESIGN
           ======================================== */
        
        /* Mobile First Approach */
        
        /* Extra Small Devices (Phones) */
        @media (max-width: 575.98px) {
            .main-header-bg {
                min-height: 150px;
            }
            
            .navbar-brand img {
                height: 80px !important;
            }
            
            .text-6xl {
                font-size: 2.5rem !important;
                line-height: 1.2;
            }
            
            .professional-card {
                padding: 1rem !important;
                margin: 0.5rem 0;
            }
            
            .card-3d {
                transform: none !important;
                transition: none !important;
            }
            
            .logement-carousel {
                flex-direction: column;
                gap: 1rem;
            }
            
            .logement-card {
                width: 100% !important;
                margin-right: 0 !important;
            }
            
            .carousel-arrow {
                display: none;
            }
            
            /* Mobile Navigation */
            .navbar-custom .navbar-nav {
                text-align: center;
            }
            
            .navbar-custom .nav-link {
                padding: 0.5rem 1rem;
                margin: 0.25rem 0;
            }
            
            .dropdown-menu {
                position: static !important;
                transform: none !important;
                border: none !important;
                box-shadow: none !important;
                background: rgba(255,255,255,0.1) !important;
            }
            
            /* Mobile Forms */
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            /* Mobile Tables */
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .table th,
            .table td {
                padding: 0.5rem;
                vertical-align: middle;
            }
            
            /* Mobile Grids */
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
            }
            
            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .grid-cols-5 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            /* Mobile Images */
            img {
                max-width: 100%;
                height: auto;
            }
            
            /* Mobile Spacing */
            .mb-10 {
                margin-bottom: 2rem !important;
            }
            
            .p-4 {
                padding: 1rem !important;
            }
            
            .p-md-5 {
                padding: 1rem !important;
            }
        }
        
        /* Small Devices (Landscape Phones) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .main-header-bg {
                min-height: 180px;
            }
            
            .navbar-brand img {
                height: 100px !important;
            }
            
            .text-6xl {
                font-size: 3rem !important;
            }
            
            .grid-cols-4 {
                grid-template-columns: repeat(3, 1fr) !important;
            }
            
            .grid-cols-5 {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
        
        /* Medium Devices (Tablets) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .main-header-bg {
                min-height: 200px;
            }
            
            .navbar-brand img {
                height: 120px !important;
            }
            
            .text-6xl {
                font-size: 4rem !important;
            }
            
            .logement-carousel {
                overflow-x: auto;
                scroll-snap-type: x mandatory;
            }
            
            .logement-card {
                scroll-snap-align: start;
                min-width: 300px;
            }
        }
        
        /* Large Devices (Desktops) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .text-6xl {
                font-size: 5rem !important;
            }
        }
        
        /* Extra Large Devices (Large Desktops) */
        @media (min-width: 1200px) {
            /* Keep original styles for large screens */
        }
        
        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .card-3d:hover {
                transform: none !important;
            }
            
            .btn:hover {
                transform: none !important;
            }
            
            .navbar-brand img:hover {
                transform: none !important;
            }
        }
        
        /* High DPI Displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .navbar-brand img {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }
        
        /* Print Styles */
        @media print {
            .navbar,
            .carousel-arrow,
            .btn,
            .dropdown-menu {
                display: none !important;
            }
            
            .professional-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
        
        /* Accessibility Improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Dark Mode Support (Optional) */
        @media (prefers-color-scheme: dark) {
            /* Add dark mode styles here if needed */
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="main-header-bg">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/images/findStay-removebg-preview.png" alt="Findstay Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.accueilproprietaire') : route('locataire.accueillocataire') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.logements') : route('locataire.logementsloca') }}">Nos logements</a>
                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.reservations.index') : route('locataire.reservations.index') }}">Mes réservations</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.annoncesproprietaire.index') : route('locataire.annonces.index') }}">Mes annonces</a>
                        </li>
                        @if(auth()->user()->role_uti === 'locataire')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('locataire.favorites') }}">Mes favoris</a>
                        </li>
                        @endif
                    </ul>
                    <div class="d-flex align-items-center gap-3 ms-auto">
                        <!-- Chat Icon -->
                        <div class="dropdown">
                            <a href="#" id="chatDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative dropdown-toggle">
                                <i class="fas fa-comments fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-primary" style="color: #24507a !important; background: #fff !important; border: 2px solid #24507a !important; min-width: 28px; min-height: 28px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                                    {{ auth()->user()->receivedMessages()->where('is_read', false)->count() ?: 0 }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-messages p-3" aria-labelledby="chatDropdown">
                                <h6 class="dropdown-header">Conversations</h6>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    @foreach (App\Models\Conversation::where('expediteur_id', auth()->id())->orWhere('destinataire_id', auth()->id())->with(['expediteur', 'destinataire'])->latest('date_debut_conv')->get() as $conv)
                                        @php
                                            $otherUser = ($conv->expediteur_id === auth()->id()) ? $conv->destinataire : $conv->expediteur;
                                        @endphp
                                        <li class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                                <a class="dropdown-item d-flex align-items-center gap-2 flex-grow-1 open-conversation-link" href="#" data-conversation-id="{{ $conv->id }}">
                                                    <img src="{{ $otherUser->photodeprofil_uti ? asset('storage/' . $otherUser->photodeprofil_uti) : asset('images/default-avatar.png') }}" alt="{{ $otherUser->prenom }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <span>{{ $otherUser->prenom }} {{ $otherUser->nom_uti }}</span>
                                                </a>
                                            </div>
                                            <button type="button" class="btn btn-link text-danger p-0 ms-2 delete-conversation-btn" data-conversation-id="{{ $conv->id }}" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('messages.index') }}" class="dropdown-item text-center">Voir tous les messages</a>
                            </ul>
                        </div>
                        <!-- Notification Icon -->
                        <div class="dropdown">
                            <a href="#" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="position-relative dropdown-toggle">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-white text-primary" style="color: #24507a !important; background: #fff !important; border: 2px solid #24507a !important; min-width: 28px; min-height: 28px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem;">
                                    {{ auth()->user()->notifications()->whereNull('read_at')->count() ?: 0 }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-notifications p-3" aria-labelledby="notifDropdown">
                                <h6 class="dropdown-header">Notifications</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <a href="{{ route('notifications.index') }}" class="dropdown-item text-center p-0" style="flex:1;">Voir toutes les notifications</a>
                                    <button id="deleteAllNotificationsBtn" class="btn btn-link text-danger p-0 ms-2" style="white-space:nowrap;">Supprimer toutes</button>
                                </div>
                                <div style="max-height: 300px; overflow-y: auto;" id="notifListContainer">
                                    @forelse(auth()->user()->notifications()->whereNull('read_at')->get() as $notification)
                                        <div class="notif-item d-flex align-items-center justify-content-between" data-notification-id="{{ $notification->id }}">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $notification->data['avatar'] ?? asset('images/default-avatar.png') }}" class="notif-avatar" alt="avatar" style="background: #fff;">
                                                <div class="notif-content">
                                                    <div class="notif-name">
                                                        {{ $notification->data['name'] ?? 'Utilisateur' }}
                                                    </div>
                                                    <div class="notif-message">
                                                        @if(isset($notification->data['type']) && $notification->data['type'] === 'reservation')
                                                            demande de reservation
                                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'comment')
                                                            {{ $notification->data['name'] ?? 'Utilisateur' }} a commenté votre poste
                                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'reservation_status')
                                                            {{ $notification->data['message'] ?? '' }}
                                                        @else
                                                            {{ $notification->data['message'] ?? $notification->data['body'] ?? '' }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!$notification->read_at)
                                                <button class="btn btn-sm btn-outline-primary mark-read-btn" onclick="markAsRead('{{ $notification->id }}', this)">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    @empty
                                        <span class="dropdown-item text-muted">Aucune notification</span>
                                    @endforelse
                                </div>
                            </ul>
                        </div>
                        <!-- Profile Picture Icon -->
                        <div class="ms-2">
                            <a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.profile.index') : route('locataire.profile.index') }}">
                                @php
                                    $profilePhoto = auth()->user()->photodeprofil_uti;
                                    if ($profilePhoto) {
                                        $photoUrl = asset('storage/' . $profilePhoto);
                                    } else {
                                        $photoUrl = asset('images/default-avatar.png');
                                    }
                                @endphp
                                <img src="{{ $photoUrl }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #24507a;" onerror="this.src='{{ asset('images/default-avatar.png') }}';">
                            </a>
                        </div>
                        <!-- Settings Icon Dropdown -->
                        <div class="dropdown ms-2">
                            <a href="#" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link p-0 dropdown-toggle d-flex align-items-center" style="box-shadow:none;">
                                
                                <i class="fas fa-cog fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Modifier le profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.password.form') }}">Changer le mot de passe</a></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('profile.delete.form') }}">Supprimer le compte</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="header-welcome">
            @yield('header')
        </div>
        <div class="text-center mb-10 text-6xl font-extrabold" style="font-family: 'Inknut Antiqua', serif; color: white; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8), 0 0 20px rgba(0, 0, 0, 0.5); padding: 20px 0; letter-spacing: 1px;">
            @php
                $hour = now()->hour;
                $greeting = $hour < 12 ? 'Bonjour' : ($hour < 18 ? 'Bon après-midi' : 'Bonsoir');
            @endphp
            <span>{{ $greeting }},</span> 
            <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom_uti }}</span> 
        </div>
    </div>
    <main class="main-content container">
        @yield('content')
    </main>
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center text-md-start footer-section">
                    <img src="/images/findStay-removebg-preview.png" alt="Findstay Logo" class="footer-logo">
                    <div>Trouvez votre chez-vous avec FindStay. Facile, rapide, fiable</div>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Nos Services</div>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">On Quelques chiffres</a></li>
                    </ul>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Contact</div>
                    <div>FindStay@gmail.com</div>
                </div>
                <div class="col-md-3 text-center footer-section">
                    <div class="footer-title">Navigation</div>
                    <ul class="footer-links">
                        <li><a href="/">Accueil</a></li>
                        <li><a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.logements') : route('locataire.logementsloca') }}">Nos logements</a></li>
                        <li><a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.reservations.index') : route('locataire.reservations.index') }}">Mes réservations</a></li>
                        <li><a href="{{ auth()->user()->role_uti === 'proprietaire' ? route('proprietaire.annoncesproprietaire.index') : route('locataire.annonces.index') }}">Mes annonces</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom mt-3">
                © 2025 FindStay. Tous droits réservés.
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <div id="chatBoxContainer" style="display:none;"></div>
    <script>
        function attachCloseChatHandler() {
            const chatBox = document.getElementById('chatBoxContainer');
            const btn = chatBox.querySelector('.close-chat-btn');
            if (btn) {
                btn.onclick = () => { chatBox.style.display = "none"; };
            }
        }
        (function() {
            const chatBox = document.getElementById("chatBoxContainer");
            document.addEventListener('click', function(e) {
                // Open conversation only if clicking the .open-conversation-link
                const openLink = e.target.closest('.open-conversation-link');
                if (openLink) {
                    e.preventDefault();
                    const convId = openLink.getAttribute("data-conversation-id");
                    chatBox.innerHTML = "<div class='text-center p-5'><div class='spinner-border' role='status'><span class='visually-hidden'>Loading…</span></div></div>";
                    chatBox.style.display = "flex";
                    fetch(`/conversations/view/${convId}`, { headers: { "Accept": "application/json" } })
                        .then(resp => resp.text())
                        .then(html => { chatBox.innerHTML = html; attachCloseChatHandler(); })
                        .catch(err => { chatBox.innerHTML = '<p class=\"text-danger\">Erreur de chargement de la conversation.</p>'; });
                }
            });
            attachCloseChatHandler();
        })();
    </script>
    <script>
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-conversation-btn');
        if (btn) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const convId = btn.getAttribute('data-conversation-id');
            if (confirm('Voulez-vous vraiment supprimer cette conversation ?')) {
                fetch(`/conversations/${convId}/delete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(resp => resp.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('li').remove();
                    }
                });
            }
            return false;
        }
    });
    </script>
    <script>
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'message-form-modal') {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const chatBox = document.getElementById('chatBoxContainer');
            fetch('/messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success && data.conversation_id) {
                    // Reload the conversation via AJAX
                    fetch(`/conversations/view/${data.conversation_id}`, { headers: { "Accept": "application/json" } })
                        .then(resp => resp.text())
                        .then(html => { chatBox.innerHTML = html; attachCloseChatHandler(); })
                } else {
                    let msg = 'Erreur lors de l\'envoi du message.';
                    if (data && data.error) msg += '\n' + data.error;
                    alert(msg);
                }
            })
            .catch(async (err) => {
                let msg = 'Erreur lors de l\'envoi du message.';
                if (err.response) {
                    const data = await err.response.json();
                    if (data && data.error) msg += '\n' + data.error;
                }
                alert(msg);
            });
        }
    });
    </script>
    <script>
    document.getElementById('deleteAllNotificationsBtn')?.addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment supprimer toutes les notifications ?')) {
            fetch('/notifications/delete-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifListContainer').innerHTML = '<span class="dropdown-item text-muted">Aucune notification</span>';
                }
            });
        }
    });
    </script>
    <script>
    function markAsRead(notificationId, btn) {
        fetch(`/notifications/${notificationId}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.remove();
                // Update the unread count in the navbar
                const unreadCountElement = document.querySelector('.fa-bell + .badge, #unread-notifications-count');
                if (unreadCountElement) {
                    let currentCount = parseInt(unreadCountElement.textContent);
                    if (currentCount > 0) {
                        unreadCountElement.textContent = currentCount - 1;
                        if (currentCount - 1 === 0) {
                            unreadCountElement.style.display = 'none';
                        }
                    }
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
    
    <!-- Enhanced JavaScript for Professional Animations -->
    <script>
    // Enhanced Animation System
    class AnimationSystem {
        constructor() {
            this.init();
        }
        
        init() {
            this.setupScrollAnimations();
            this.setupHoverEffects();
            this.setupFormAnimations();
            this.setupLoadingStates();
            this.setupMicroInteractions();
        }
        
        setupScrollAnimations() {
            // Intersection Observer for scroll-triggered animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animate-in');
                        }, index * 100);
                    }
                });
            }, observerOptions);
            
            // Observe elements for animation
            document.querySelectorAll('.card, .professional-card, .section-title').forEach(el => {
                observer.observe(el);
            });
        }
        
        setupHoverEffects() {
            // Enhanced button hover effects
            document.querySelectorAll('.btn, .btn-primary-custom').forEach(button => {
                button.addEventListener('mouseenter', (e) => {
                    this.createRippleEffect(e.target, e);
                });
            });
            
            // Card hover effects
            document.querySelectorAll('.card, .professional-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-8px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                });
            });
        }
        
        setupFormAnimations() {
            // Enhanced form focus animations
            document.querySelectorAll('.form-control, .form-select').forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('form-focused');
                });
                
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('form-focused');
                });
            });
        }
        
        setupLoadingStates() {
            // Add loading states to buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    if (!button.classList.contains('loading')) {
                        this.showLoadingState(button);
                    }
                });
            });
        }
        
        setupMicroInteractions() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Enhanced dropdown animations
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const menu = toggle.nextElementSibling;
                    if (menu && menu.classList.contains('dropdown-menu')) {
                        menu.style.animation = 'dropdownFadeIn 0.3s ease';
                    }
                });
            });
        }
        
        createRippleEffect(button, event) {
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            button.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        }
        
        showLoadingState(button) {
            button.classList.add('loading');
            button.disabled = true;
            
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading-spinner"></span> Loading...';
            
            setTimeout(() => {
                button.classList.remove('loading');
                button.disabled = false;
                button.innerHTML = originalText;
            }, 2000);
        }
    }
    
    // Initialize animation system
    document.addEventListener('DOMContentLoaded', () => {
        new AnimationSystem();
        
        // Add CSS animation classes
        const style = document.createElement('style');
        style.textContent = `
            .animate-in {
                animation: slideInUp 0.6s ease forwards;
            }
            
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .form-focused {
                transform: translateY(-2px);
            }
            
            .form-focused .form-control,
            .form-focused .form-select {
                box-shadow: 0 0 0 0.2rem rgba(124, 159, 192, 0.25);
            }
            
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            }
            
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .btn.loading {
                pointer-events: none;
                opacity: 0.7;
            }
            
            .loading-spinner {
                display: inline-block;
                width: 16px;
                height: 16px;
                border: 2px solid transparent;
                border-top: 2px solid currentColor;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin-right: 8px;
            }
            
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
            
            /* Enhanced transitions for all interactive elements */
            * {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            /* Smooth page transitions */
            body {
                animation: fadeIn 0.5s ease;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        // Enhanced page load animations
        document.body.classList.add('page-loaded');
        
        // Add staggered animation to elements
        const animateElements = document.querySelectorAll('.card, .professional-card, .btn, .form-control');
        animateElements.forEach((el, index) => {
            setTimeout(() => {
                el.classList.add('animate-in');
            }, index * 50);
        });
    });
    
    // Enhanced form validation
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton && !submitButton.classList.contains('loading')) {
                    // Enhanced validation feedback
                    const invalidInputs = form.querySelectorAll(':invalid');
                    invalidInputs.forEach(input => {
                        input.classList.add('shake');
                        setTimeout(() => {
                            input.classList.remove('shake');
                        }, 500);
                    });
                }
            });
        });
    });
    
    // Add shake animation
    const shakeStyle = document.createElement('style');
    shakeStyle.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease;
            border-color: var(--danger) !important;
        }
    `;
    document.head.appendChild(shakeStyle);
    
    // Enhanced notification system
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 16px 24px;
                border-radius: 12px;
                color: white;
                font-weight: 600;
                z-index: 9999;
                animation: slideInRight 0.3s ease, slideOutRight 0.3s ease 2.7s forwards;
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }
            
            .notification-success {
                background: linear-gradient(135deg, #28a745, #20c997);
            }
            
            .notification-error {
                background: linear-gradient(135deg, #dc3545, #c82333);
            }
            
            .notification-info {
                background: linear-gradient(135deg, #17a2b8, #138496);
            }
            
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        
        if (!document.querySelector('#notification-styles')) {
            notificationStyle.id = 'notification-styles';
            document.head.appendChild(notificationStyle);
        }
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // Make notification function globally available
    window.showNotification = showNotification;
    
    // Enhanced smooth scroll with easing
    function smoothScrollTo(element, duration = 800) {
        const targetPosition = element.offsetTop - 80;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        let startTime = null;
        
        function animation(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animation);
        }
        
        function ease(t, b, c, d) {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        }
        
        requestAnimationFrame(animation);
    }
    
    // Make smoothScrollTo globally available
    window.smoothScrollTo = smoothScrollTo;
    
    // Enhanced parallax effect for hero sections
    function setupParallax() {
        const heroElements = document.querySelectorAll('.main-header-bg, .hero-section');
        
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            
            heroElements.forEach(element => {
                const speed = element.dataset.speed || 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    }
    
    // Initialize parallax on page load
    document.addEventListener('DOMContentLoaded', setupParallax);
    
    // Enhanced keyboard navigation
    document.addEventListener('keydown', (e) => {
        // Escape key closes modals
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        }
    });
    
    // Performance optimization: Debounce scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Enhanced scroll performance
    const optimizedScroll = debounce(() => {
        // Scroll-related animations
        const scrolled = window.pageYOffset;
        
        // Add/remove sticky classes
        if (scrolled > 100) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    }, 10);
    
    window.addEventListener('scroll', optimizedScroll);
    
    </script>
</body>
</html>