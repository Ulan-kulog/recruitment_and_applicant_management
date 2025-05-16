<?php
ob_start();

// Security headers
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com; img-src 'self' data:; font-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; connect-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// Sanitize GET parameter
function sanitize_page($page)
{
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FFF6E8;
            color: #594423;
        }

        .sidebar-collapsed {
            width: 100px;
        }

        .sidebar-expanded {
            width: 320px;
        }

        .sidebar-collapsed .menu-name span,
        .sidebar-collapsed .menu-name .arrow {
            display: none;
        }

        .sidebar-collapsed .menu-name i {
            margin-right: 0;
        }

        .sidebar-collapsed .menu-drop {
            display: none;
        }

        .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            inset: 0;
            z-index: 40;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        .close-sidebar-btn {
            display: none;
        }

        .menu-name {
            position: relative;
            overflow: hidden;
        }

        .menu-name::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background-color: #4E3B2A;
            transition: width 0.3s ease;
        }

        .menu-name:hover::after {
            width: 100%;
        }

        /* Logo Styling */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #594423;
            background-color: #F7E8CA;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text img {
            height: 24px;
        }

        .sidebar-collapsed .logo-text {
            display: none;
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(89, 68, 35, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(89, 68, 35, 0.1);
            max-width: 100%;
            margin: 0 auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background-color: #F7E8CA;
            padding: 16px 20px;
            font-weight: 600;
            color: #594423;
            text-align: left;
            border: none;
            position: relative;
            font-family: 'Cinzel', serif;
        }

        .table th:first-child {
            border-top-left-radius: 8px;
        }

        .table th:last-child {
            border-top-right-radius: 8px;
            text-align: center;
        }

        .table td {
            padding: 16px 20px;
            vertical-align: middle;
            color: #594423;
            border-bottom: 1px solid rgba(89, 68, 35, 0.1);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .actions .btn {
            padding: 8px;
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #594423;
            color: #594423;
            background-color: transparent;
            transition: all 0.2s ease;
        }

        .actions .btn:hover {
            background-color: #594423;
            color: white;
            transform: translateY(-2px);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #594423;
            border-color: #594423;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #4E3B2A;
            border-color: #4E3B2A;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
            border: none;
        }

        .modal-header {
            border-bottom: 1px solid #F7E8CA;
            padding: 1rem 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #F7E8CA;
            padding: 1rem 1.5rem;
        }

        .detail-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .detail-item h6 {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .detail-item p {
            margin-bottom: 10px;
            color: #6c757d;
        }

        .detail-item p strong {
            color: #495057;
            font-weight: 600;
            min-width: 100px;
            display: inline-block;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #F7E8CA;
            box-shadow: 0 0 0 0.25rem rgba(89, 68, 35, 0.25);
        }

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 900px;
        }

        .page-header h1 {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            color: #594423;
            font-size: 1.75rem;
            margin: 0;
        }

        /* Container */
        .container-fluid {
            padding: 24px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .alert {
            width: 100%;
            max-width: 900px;
        }

        @media (max-width: 968px) {
            .sidebar {
                position: fixed;
                left: -100%;
                transition: left 0.3s ease-in-out;
            }

            .sidebar.mobile-active {
                left: 0;
            }

            .main {
                margin-left: 0 !important;
            }

            .close-sidebar-btn {
                display: block;
            }

            .table-container {
                padding: 1rem;
            }

            .table th,
            .table td {
                padding: 12px 10px;
            }
        }

        /* Minimalist scrollbar styling */
        /* WebKit browsers */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(89, 68, 35, 0.3);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(89, 68, 35, 0.5);
        }

        /* Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(89, 68, 35, 0.3) transparent;
        }
    </style>
</head>

<body class="bg-[#FFF6E8]">