body {
    background: #f4f6f9;
    font-family: Arial, sans-serif;
}

.sidebar {
    width: 230px;
    min-height: 100vh;
    background: #172554;
    flex-shrink: 0;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 5px;
}

.sidebar a:hover {
    background: #2563eb;
}

.main-content {
    min-width: 0;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px #00000010;
}

@media(max-width:768px) {
    .sidebar {
        width: 150px;
    }

    .main-content {
        padding: 12px !important;
    }
}