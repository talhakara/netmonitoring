<html>
<head>
    <title>Ping Kontrol</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        :root[data-theme="light"] {
            --bg-color: #f5f6fa;
            --text-color: #2c3e50;
            --card-bg: white;
            --card-border: #ddd;
            --secondary-text: #666;
            --modal-bg: white;
            --input-bg: white;
            --input-border: #ddd;
            --input-text: #2c3e50;
            --hover-color: rgba(0, 0, 0, 0.05);
            --card-online-bg: #e1f7e1;
            --card-offline-bg: #fde2e2;
            --card-online-border: #2ecc71;
            --card-offline-border: #e74c3c;
            --delete-btn-color: #666;
            --card-ping-excellent: #e1f7e1;  /* 0-15ms - yeşil */
            --card-ping-good: #f0f7e1;      /* 16-35ms - yeşil-sarı */
            --card-ping-warning: #f7f3e1;    /* 36-50ms - sarı */
            --card-ping-critical: #f7e9e1;   /* 50ms+ - turuncu */
            
            --border-ping-excellent: #2ecc71;
            --border-ping-good: #a7c93e;
            --border-ping-warning: #f1c40f;
            --border-ping-critical: #e67e22;
        }

        :root[data-theme="dark"] {
            --bg-color: #1a1a1a;
            --text-color: #ffffff;
            --card-bg: #2d2d2d;
            --card-border: #404040;
            --secondary-text: #b3b3b3;
            --modal-bg: #2d2d2d;
            --input-bg: #363636;
            --input-border: #404040;
            --input-text: #ffffff;
            --hover-color: rgba(255, 255, 255, 0.05);
            --card-online-bg: rgba(46, 204, 113, 0.2);
            --card-offline-bg: rgba(231, 76, 60, 0.2);
            --card-online-border: #2ecc71;
            --card-offline-border: #e74c3c;
            --delete-btn-color: #999;
            --card-ping-excellent: rgba(46, 204, 113, 0.2);
            --card-ping-good: rgba(167, 201, 62, 0.2);
            --card-ping-warning: rgba(241, 196, 15, 0.2);
            --card-ping-critical: rgba(230, 126, 34, 0.2);
            
            --border-ping-excellent: #2ecc71;
            --border-ping-good: #a7c93e;
            --border-ping-warning: #f1c40f;
            --border-ping-critical: #e67e22;
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
        }

        .container {
            max-width: 100%;
            margin: 0;
        }

        .header {
        }

        .add-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .form-group label {
            display: flex;
            align-content: center;
            align-items: center;
            align-self: center;
            margin-bottom: 0px;
            color: var(--secondary-text);
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            font-size: 14px;
            background: var(--input-bg);
            color: var(--input-text);
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 9px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .device-grid {
            padding: 20px;
        }

        .device-card {
            padding: 12px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s;
            position: relative;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            min-height: 110px;
        }

        .device-card.online {
            background: var(--card-online-bg);
            border: 1px solid var(--card-online-border);
        }

        .device-card.offline {
            background: var(--card-offline-bg);
            border: 1px solid var(--card-offline-border);
        }

        .device-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .device-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            padding-right: 50px;
        }

        .device-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .device-ip {
            color: var(--secondary-text);
            margin-bottom: 12px;
            font-size: 13px;
        }

        .device-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .status-badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 500;
            font-size: 11px;
            white-space: nowrap;
            min-width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-badge i {
            font-size: 10px;
        }

        .online .status-badge {
            background: var(--card-online-border);
            color: white;
        }

        .offline .status-badge {
            background: var(--card-offline-border);
            color: white;
        }

        .device-info {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: var(--secondary-text);
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid var(--card-border);
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--delete-btn-color);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            font-size: 12px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 12px;
            opacity: 0;
        }

        .device-card:hover .delete-btn {
            opacity: 1;
        }

        /* Karanlık tema için hover efekti */
        [data-theme="dark"] .delete-btn:hover {
            background-color: rgba(231, 76, 60, 0.2);
        }

        /* Responsive tasarım için medya sorguları */
        @media (min-width: 1600px) {
            .device-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 1400px) {
            .device-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .device-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 900px) {
            .device-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 600px) {
            .device-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 10px;
            }
        }

        /* Modal stilleri */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background: var(--modal-bg);
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 1.2em;
            font-weight: 600;
            color: var(--text-color);
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5em;
            color: var(--secondary-text);
            cursor: pointer;
            padding: 0;
        }

        .close-modal:hover {
            color: #e74c3c;
        }

        /* Ekleme butonu stili */
        .add-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3498db;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s;
            z-index: 100;
        }

        .add-button:hover {
            transform: scale(1.1);
        }

        /* Form stilleri */
        .modal-form {
            display: grid;
            gap: 15px;
        }

        .form-group {
            display: grid;
            gap: 5px;
        }

        .form-group label {
            font-weight: 500;
            color: var(--secondary-text);
        }

        .form-group input {
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            font-size: 14px;
        }

        .submit-btn {
            background: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .submit-btn:hover {
            background: #2980b9;
        }

        /* Tema değiştirme butonu */
        .theme-switch-wrapper {
            position: static;
        }

        .theme-switch {
            display: inline-block;
            height: 24px;
            position: relative;
            width: 45px;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #f1c40f;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            background-color: #fff;
            bottom: 3px;
            content: "";
            height: 18px;
            left: 3px;
            position: absolute;
            transition: .4s;
            width: 18px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .slider .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            transition: .4s;
            color: white;
        }

        .slider .sun {
            right: 8px;
        }

        .slider .moon {
            left: 8px;
        }

        input:checked + .slider {
            background-color: #2c3e50;
        }

        input:checked + .slider:before {
            transform: translateX(21px);
        }

        input:checked + .slider .sun {
            opacity: 0;
        }

        input:checked + .slider .moon {
            opacity: 1;
        }

        input:not(:checked) + .slider .sun {
            opacity: 1;
        }

        input:not(:checked) + .slider .moon {
            opacity: 0;
        }

        /* Hover efektleri */
        .device-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        /* Geçiş animasyonları */
        .device-card,
        .modal-content,
        input,
        select,
        button {
            transition: all 0.3s ease;
        }

        .form-group select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group select option {
            background: var(--input-bg);
            color: var(--input-text);
        }

        /* IP ve Ping satırını düzenle */
        .device-ip-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 8px 0;
            padding: 4px 0;
        }

        .device-ip-row .ip {
            color: var(--secondary-text);
            font-size: 12px;
        }

        .device-ip-row .ping {
            color: var(--text-color);
            font-weight: 500;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            background: var(--hover-color);
        }

        /* Ping durumuna göre kart stilleri */
        .device-card.ping-excellent {
            background: var(--card-ping-excellent);
            border: 1px solid var(--border-ping-excellent);
        }

        .device-card.ping-good {
            background: var(--card-ping-good);
            border: 1px solid var(--border-ping-good);
        }

        .device-card.ping-warning {
            background: var(--card-ping-warning);
            border: 1px solid var(--border-ping-warning);
        }

        .device-card.ping-critical {
            background: var(--card-ping-critical);
            border: 1px solid var(--border-ping-critical);
        }

        .action-buttons {
            position: fixed;
            top: 20px;
            right: 70px;
            z-index: 100;
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .action-btn {
            background: #3498db;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s;
            border: none;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .export-btn {
            background: #27ae60;
        }

        .import-btn {
            background: #8e44ad;
        }

        /* Tüm butonlar için ortak stiller */
        .add-button,
        .action-btn {
            background: #3498db;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s;
            border: none;
        }

        /* Butonlar arası boşluk */
        .action-buttons {
            position: fixed;
            top: 20px;
            right: 70px;
            z-index: 100;
            display: flex;
            gap: 6px;
            align-items: center;
        }

        /* Ekleme butonu pozisyonu */
        .add-button {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        /* Hover efekti */
        .add-button:hover,
        .action-btn:hover {
            transform: scale(1.1);
            background: #2980b9;
        }

        /* Export ve Import butonlarını kaldır */
        .export-btn,
        .import-btn {
            background: #3498db;
        }

        /* Tema switch boyutlarını güncelle */
        .theme-switch {
            display: inline-block;
            height: 20px;
            position: relative;
            width: 40px;
        }

        .slider:before {
            bottom: 2px;
            height: 16px;
            width: 16px;
            left: 2px;
        }

        .slider .icon {
            font-size: 10px;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .last-check {
            font-size: 14px;
            color: var(--secondary-text);
            font-weight: normal;
            margin-left: 15px;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 20px;
            }
            
            .last-check {
                display: block;
                margin-left: 0;
                margin-top: 5px;
            }
        }

        .card-actions {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 2px;
            opacity: 0;
            transition: opacity 0.2s;
            padding: 2px;
            border-radius: 4px;
        }

        .device-card:hover .card-actions {
            opacity: 1;
        }

        .edit-btn {
            background: none;
            position: relative;
            top: 0px;
            right: 0px;
            border: none;
            cursor: pointer;
            padding: 3px;
            font-size: 11px;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            transition: all 0.2s;
        }

        .delete-btn {
            background: none;
            position: relative;
            top: 0px;
            right: 0px;
            border: none;
            cursor: pointer;
            padding: 3px;
            font-size: 11px;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            transition: all 0.2s;
        }

        .edit-btn:hover {
            color: #3498db;
            background-color: var(--hover-color);
        }

        .delete-btn:hover {
            color: #e74c3c;
            background-color: var(--hover-color);
        }

        /* Butonlar için tooltip */
        .edit-btn::after,
        .delete-btn::after {
            content: attr(title);
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: rgba(0,0,0,0.8);
            color: white;
            font-size: 11px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
        }

        .edit-btn:hover::after,
        .delete-btn:hover::after {
            opacity: 1;
            visibility: visible;
        }

        .settings-btn {
            background: #3498db;
        }

        .settings-btn i {
            animation: spin 10s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Form grupları için grid yapısı */
        .form-group {
            display: grid;
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .form-group label {
            font-size: 13px;
            color: var(--secondary-text);
        }

        .form-group input[type="number"],
        .form-group select {
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            color: var(--input-text);
        }

        /* Action buttons sıralaması */
        .action-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .action-btn {
            order: 2;
        }

        .settings-btn {
            order: 1;
        }

        .theme-switch-wrapper {
            order: 3;
        }

        /* Ayarlar butonu animasyonu */
        .settings-btn i {
            animation: spin 15s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Ayarlar modalı için ek stiller */
        #settingsForm .form-group {
            margin-bottom: 15px;
        }

        #settingsForm label {
            display: flex;
            margin-bottom: 5px;
            font-weight: 500;
        }

        #settingsForm input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            color: var(--input-text);
        }

        #settingsForm input[type="number"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .device-group {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--card-border);
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--card-border);
        }

        .group-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .group-icon {
            width: 40px;
            height: 40px;
            background: var(--hover-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-text);
            font-size: 18px;
        }

        .group-title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .group-title h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .group-stats {
            font-size: 13px;
            color: var(--secondary-text);
        }

        .device-count {
            background: var(--hover-color);
            color: var(--text-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Grupsuz cihazlar için grid */
        .ungrouped-devices {
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        /* Gruplar container */
        .groups-container {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 15px;
            width: 100%;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        /* Grup kartı stilleri */
        .device-group {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 0px;
            border: 1px solid var(--card-border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            height: 185px;
        }

        /* Grup header */
        .group-header {
            padding: 5px;
            border-bottom: 1px solid var(--card-border);
        }

        /* Grup içindeki cihaz grid'i */
        .device-group .device-grid {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            gap: 10px;
            overflow-y: auto;
            padding: 10px;
            max-height: 150px;
            scrollbar-width: thin;
            scrollbar-color: var(--secondary-text) var(--hover-color);
        }

        /* Webkit tabanlı tarayıcılar için scroll tasarımı */
        .device-group .device-grid::-webkit-scrollbar {
            width: 6px;
        }

        .device-group .device-grid::-webkit-scrollbar-track {
            background: var(--hover-color);
            border-radius: 3px;
        }

        .device-group .device-grid::-webkit-scrollbar-thumb {
            background: var(--secondary-text);
            border-radius: 3px;
        }

        /* Scroll hover efekti */
        .device-group .device-grid::-webkit-scrollbar-thumb:hover {
            background: var(--text-color);
        }

        /* Scroll görünürlüğü */
        .device-group .device-grid:hover::-webkit-scrollbar-thumb {
            background: var(--text-color);
        }

        /* Responsive tasarım */
        @media (max-width: 1600px) {
            .groups-container {
                grid-template-columns: repeat(1, 1fr);
            }
            .device-group .device-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 1400px) {
            .groups-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .groups-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media (max-width: 768px) {
            .groups-container {
                grid-template-columns: 1fr;
            }
            
            .device-group {
                height: auto;
                min-height: 350px;
            }
        }

        /* Container genişliği */
        .container {
            max-width: 100%;
            margin: 0;
        }

        /* Grupsuz cihazlar grid'i */
        .ungrouped-devices {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
            width: 100%;
        }

        /* Sekmeler için stiller */
        .tabs {
            display: flex;
            border-bottom: 1px solid var(--card-border);
            margin-bottom: 20px;
        }

        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: none;
            color: var(--secondary-text);
            cursor: pointer;
            font-size: 14px;
            position: relative;
        }

        .tab-btn.active {
            color: var(--text-color);
            font-weight: 500;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #3498db;
        }

        .tab-content {
            position: relative;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        /* Grup listesi stilleri */
        .groups-list {
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 6px;
            margin-bottom: 10px;
            transition: all 0.2s;
        }

        .group-item:hover {
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .group-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .group-icon {
            width: 32px;
            height: 32px;
            background: var(--hover-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-text);
        }

        .group-details {
            flex: 1;
        }

        .group-name {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 4px;
        }

        .group-stats {
            font-size: 12px;
            color: var(--secondary-text);
        }

        .group-actions {
            display: flex;
            gap: 6px;
        }

        .group-btn {
            padding: 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            color: var(--secondary-text);
            background: none;
            transition: all 0.2s;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .group-btn:hover {
            background: var(--hover-color);
        }

        .group-btn.edit-group:hover {
            color: #3498db;
        }

        .group-btn.delete-group:hover {
            color: #e74c3c;
        }

        .group-edit-input {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            color: var(--input-text);
            display: none;
        }

        .group-edit-input.editing {
            display: block;
        }

        .group-name.editing {
            display: none;
        }

        /* Yeni grup ekleme formu */
        .group-form-wrapper {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 6px;
            padding: 15px;
        }

        .group-input-wrapper {
            display: flex;
            gap: 8px;
        }

        .group-input-wrapper input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            background: var(--input-bg);
            color: var(--input-text);
        }

        .add-group-btn {
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .add-group-btn:hover {
            background: #2980b9;
        }

        /* Form satırı için stil */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-row .form-group {
            margin: 0;
        }

        /* Responsive tasarım için */
        @media (max-width: 480px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        .range-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .range-value {
            min-width: 50px;
            text-align: right;
        }
        
        input[type="range"] {
            flex: 1;
            height: 5px;
            background: var(--input-border);
            border-radius: 5px;
            outline: none;
            -webkit-appearance: none;
        }
        
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            background: #3498db;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .test-sound-btn {
            margin-top: 20px;
            width: 100%;
            background: #3498db;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .test-sound-btn:hover {
            background: #2980b9;
        }
        
        .switch-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .save-btn {
            flex: 1;
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .save-btn:hover {
            background: #219a52;
        }
        
        .test-sound-btn {
            flex: 1;
            margin-top: 0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .switch-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .switch-slider {
            background-color: #3498db;
        }

        input:checked + .switch-slider:before {
            transform: translateX(22px);
        }

        [data-theme="dark"] .switch-slider {
            background-color: #666;
        }

        [data-theme="dark"] input:checked + .switch-slider {
            background-color: #2980b9;
        }

        /* Tema değiştirici için özel stil */
        .theme-switch-wrapper .switch-slider {
            background-color: #2c3e50;
        }
        
        .theme-switch-wrapper .switch-slider:before {
            background-color: #f1c40f;
        }
        
        .theme-switch-wrapper input:checked + .switch-slider {
            background-color: #34495e;
        }
        
        .theme-switch-wrapper input:checked + .switch-slider:before {
            background-color: #7f8c8d;
        }
        
        .theme-switch-wrapper .icon {
            color: white;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            transition: .3s;
        }
        
        .theme-switch-wrapper .sun {
            left: 6px;
        }
        
        .theme-switch-wrapper .moon {
            right: 6px;
        }

        .last-check {
            font-size: 14px;
            color: var(--secondary-text);
            font-weight: normal;
            margin-left: 15px;
        }

        .status-bar {
            display: flex;
            align-items: center;
            padding: 10px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 0;
            border-top: none;
            border-left: none;
            border-right: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            justify-content: space-between;
            overflow: hidden;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .status-title {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 15px;
            border-right: 1px solid var(--card-border);
            min-width: 200px;
        }
        
        .status-title i {
            font-size: 20px;
            color: var(--text-color);
            opacity: 0.8;
        }
        
        .status-title h1 {
            font-size: 18px;
            margin: 0;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .status-items {
            display: flex;
            flex: 1;
            min-width: 0;
            border-radius: 6px;
            overflow: hidden;
            background: var(--hover-color);
        }
        
        .status-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            position: relative;
        }
        
        .status-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: var(--text-color);
            padding: 15px;
            border-right: 1px solid var(--card-border);
            flex: 1;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
            min-width: 150px;
            background: transparent;
            gap: 8px;
            position: relative;
        }
        
        .status-item i {
            font-size: 16px;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .status-item span {
            font-weight: 500;
        }
        
        .status-item:hover i {
            opacity: 1;
        }
        
        .status-actions .action-btn {
            background: transparent;
            color: var(--text-color);
            padding: 8px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }
        
        .status-actions .action-btn span {
            display: none;
            position: absolute;
            right: 100%;
            background: var(--card-bg);
            padding: 6px 12px;
            border-radius: 4px;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-right: 8px;
            font-size: 12px;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .status-actions .action-btn:hover span {
            display: block;
            opacity: 1;
        }
        
        .status-actions .action-btn:hover {
            background: var(--hover-color);
        }
        
        .status-actions .theme-switch-wrapper {
            margin: 0;
            margin-left: 5px;
        }

        @media (max-width: 768px) {
            .status-bar {
                flex-wrap: wrap;
                overflow: hidden;
                box-shadow: none;
                border: none;
                padding: 0;
                gap: 10px;
            }
            
            .status-title {
                width: 100%;
                justify-content: center;
                border-right: none;
                border-bottom: 1px solid var(--card-border);
                padding: 15px;
                background: var(--card-bg);
                margin-bottom: 5px;
            }
            
            .status-items,
            .status-actions {
                width: 100%;
                padding: 0;
                margin: 0 10px;
            }
            
            .status-actions {
                justify-content: center;
                background: var(--card-bg);
                border: 1px solid var(--card-border);
                border-radius: 8px;
                padding: 10px;
                margin-bottom: 10px;
            }
            
            .status-item {
                width: 50%;
                justify-content: center;
                border: 1px solid var(--card-border);
                padding: 15px 20px;
                min-width: unset;
                border-radius: 8px;
            }
            
            .status-actions .action-btn span {
                display: none !important;
            }
            
            .status-items {
                background: transparent;
            }
        }
        #settingsForm > div > div > label > span{
            margin-top: -5px;
        }

        .help-content {
            max-width: 600px;
        }

        .help-sections {
            padding: 20px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .help-section {
            margin-bottom: 25px;
        }

        .help-section h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .help-section h3 i {
            color: #3498db;
        }

        .help-section ul {
            list-style: none;
            padding: 0;
        }

        .help-section li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
            line-height: 1.5;
        }

        .help-section li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #3498db;
        }

        .help-section .status {
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }

        .status.excellent { background: var(--card-ping-excellent); color: var(--border-ping-excellent); }
        .status.good { background: var(--card-ping-good); color: var(--border-ping-good); }
        .status.warning { background: var(--card-ping-warning); color: var(--border-ping-warning); }
        .status.critical { background: var(--card-ping-critical); color: var(--border-ping-critical); }

        .developer-info {
            background: var(--hover-color);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .developer-info p {
            margin: 8px 0;
        }

        .developer-info a {
            color: #3498db;
            text-decoration: none;
        }

        .developer-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="status-bar">
                <div class="status-title">
                    <i class="fas fa-network-wired"></i>
                    <h1>Ağ Kontrol</h1>
                </div>
                <div class="status-items">
                    <div class="status-item">
                        <i class="fas fa-clock"></i>
                        Son Kontrol: <span id="lastCheck">-</span>
                    </div>
                    <div class="status-item">
                        <i class="fas fa-server"></i>
                        Toplam: <span id="totalDevices">0</span>
                    </div>
                    <div class="status-item online">
                        <i class="fas fa-check-circle"></i>
                        Çevrimiçi: <span id="onlineDevices">0</span>
                    </div>
                    <div class="status-item offline">
                        <i class="fas fa-times-circle"></i>
                        Çevrimdışı: <span id="offlineDevices">0</span>
                    </div>
                </div>
                <div class="status-actions">
                    <button class="action-btn add-btn" onclick="openModal()" title="Cihaz Ekle">
                        <i class="fas fa-plus"></i>
                        <span>Cihaz Ekle</span>
                    </button>
                    <button class="action-btn group-btn" onclick="openGroupModal()" title="Grup Yönetimi">
                        <i class="fas fa-layer-group"></i>
                        <span>Gruplar</span>
                    </button>
                    <button class="action-btn settings-btn" onclick="openSettingsModal()" title="Ayarlar">
                        <i class="fas fa-cog"></i>
                        <span>Ayarlar</span>
                    </button>
                    <button class="action-btn refresh-btn" onclick="checkDevices()" title="Yenile">
                        <i class="fas fa-sync-alt"></i>
                        <span>Yenile</span>
                    </button>
                    <button class="action-btn import-btn" onclick="importDevices()" title="İçe Aktar">
                        <i class="fas fa-file-import"></i>
                        <span>İçe Aktar</span>
                    </button>
                    <button class="action-btn export-btn" onclick="exportDevices()" title="Dışa Aktar">
                        <i class="fas fa-file-export"></i>
                        <span>Dışa Aktar</span>
                    </button>
                    <button class="action-btn help-btn" onclick="showHelp()" title="Yardım">
                        <i class="fas fa-question-circle"></i>
                        <span>Yardım</span>
                    </button>
                    <div class="theme-switch-wrapper">
                        <label class="theme-switch">
                            <input type="checkbox" id="themeSwitch">
                            <span class="slider">
                                <i class="fas fa-sun sun icon"></i>
                                <i class="fas fa-moon moon icon"></i>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="device-grid" id="deviceList">
            <!-- Cihazlar buraya JavaScript ile eklenecek -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="addDeviceModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Yeni Cihaz Ekle</div>
                <button class="close-modal" onclick="closeModal()">×</button>
            </div>
            <form class="modal-form" id="addForm">
                <div class="form-group">
                    <label>Cihaz Adı</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Cihaz Tipi</label>
                    <select name="type" required onchange="updateBrandOptions(this.value)"></select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Marka</label>
                        <select name="brand" required onchange="updateModelOptions(this.value)">
                            <option value="">Önce cihaz tipi seçin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <select name="model" required>
                            <option value="">Önce marka seçin</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>İşletim Sistemi</label>
                        <select name="os" onchange="updateOsVersions(this.value)"></select>
                    </div>
                    <div class="form-group">
                        <label>Versiyon</label>
                        <select name="osVersion" disabled>
                            <option value="">Önce işletim sistemi seçin</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>IP Adresi</label>
                    <input type="text" name="ip" required>
                </div>
                <button type="submit" class="submit-btn">Ekle</button>
            </form>
        </div>
    </div>

    <!-- <div class="action-buttons">
        <button class="action-btn settings-btn" onclick="openSettingsModal()" title="Ayarlar">
            <i class="fas fa-cog"></i>
        </button>
        <div class="theme-switch-wrapper">
            <label class="theme-switch">
                <input type="checkbox" id="themeSwitch">
                <div class="slider">
                    <i class="fas fa-sun sun icon"></i>
                    <i class="fas fa-moon moon icon"></i>
                </div>
            </label>
        </div>
        <button class="action-btn export-btn" onclick="exportData()" title="Verileri Dışa Aktar">
            <i class="fas fa-download"></i>
        </button>
        <label class="action-btn import-btn" title="Verileri İçe Aktar">
            <i class="fas fa-upload"></i>
            <input type="file" id="importFile" accept=".json" onchange="importData(this)" style="display: none;">
        </label>
    </div> -->

    <!-- Ayarlar Modal -->
    <div class="modal" id="settingsModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Ayarlar</div>
                <button class="close-modal" onclick="closeSettingsModal()">×</button>
            </div>
            <div class="tabs">
                <button class="tab-btn active" data-tab="general">Genel</button>
                <button class="tab-btn" data-tab="groups">Gruplar</button>
                <button class="tab-btn" data-tab="sound">Ses</button>
            </div>
            <div class="tab-content">
                <!-- Genel sekmesi -->
                <div class="tab-pane active" id="general">
                    <form class="modal-form" id="settingsForm">
                        <div class="form-group">
                            <label>Yenileme Süresi (saniye)</label>
                            <input type="number" name="refreshInterval" min="5" max="3600" required>
                        </div>
                        <div class="form-group">
                            <label>Ping Timeout (ms)</label>
                            <input type="number" name="pingTimeout" min="100" max="10000" required>
                        </div>
                        <div class="form-group">
                            <label>Görünüm</label>
                            <select name="viewMode">
                                <option value="compact">Kompakt</option>
                                <option value="detailed">Detaylı</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Görünüm Ayarları</label>
                            <div class="settings-group">
                                <label class="switch-label">
                                    <label class="switch">
                                        <input type="checkbox" name="groupView" id="groupView">
                                        <span class="switch-slider"></span>
                                    </label>
                                    <span>Cihazları grupla</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn">Kaydet</button>
                    </form>
                </div>
                
                <!-- Gruplar sekmesi -->
                <div class="tab-pane" id="groups">
                    <div class="groups-list">
                        <!-- Gruplar buraya JavaScript ile eklenecek -->
                    </div>
                    <div class="group-form-wrapper">
                        <form class="modal-form" id="groupForm">
                            <div class="form-group">
                                <label>Yeni Grup Ekle</label>
                                <div class="group-input-wrapper">
                                    <input type="text" name="groupName" placeholder="Grup adı girin...">
                                    <button type="submit" class="add-group-btn">
                                        <i class="fas fa-plus"></i>
                                        Ekle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Ses sekmesi -->
                <div class="tab-pane" id="sound">
                    <form class="modal-form" id="soundSettingsForm">
                        <div class="form-group">
                            <label class="switch-label">
                                <label class="switch">
                                    <input type="checkbox" name="soundEnabled">
                                    <span class="switch-slider"></span>
                                </label>
                                <span>Sesli Bildirimler</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Ses Seviyesi</label>
                            <div class="range-container">
                                <input type="range" name="volume" min="0" max="1" step="0.1" value="1">
                                <span class="range-value">100%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Konuşma Hızı</label>
                            <div class="range-container">
                                <input type="range" name="rate" min="0.1" max="2" step="0.1" value="1">
                                <span class="range-value">100%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ses Tonu</label>
                            <div class="range-container">
                                <input type="range" name="pitch" min="0" max="2" step="0.1" value="1">
                                <span class="range-value">100%</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Dil</label>
                            <select name="language">
                                <option value="tr-TR">Türkçe</option>
                                <option value="en-US">İngilizce</option>
                            </select>
                        </div>
                        <div class="button-group">
                            <button type="submit" class="save-btn">
                                <i class="fas fa-save"></i> Kaydet
                            </button>
                            <button type="button" class="test-sound-btn" onclick="testSoundSettings()">
                                <i class="fas fa-volume-up"></i> Test Et
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let devices = JSON.parse(localStorage.getItem('devices') || '[]');
        let groups = JSON.parse(localStorage.getItem('groups') || '[]');

        // Cihaz tipleri için diziler
        const deviceTypes = [
            // Sunucular
            { value: 'server_physical', label: 'Fiziksel Sunucu' },
            { value: 'server_virtual', label: 'Sanal Sunucu' },
            { value: 'server_blade', label: 'Blade Sunucu' },
            { value: 'server_backup', label: 'Yedekleme Sunucusu' },
            
            // Ağ Cihazları
            { value: 'switch_l2', label: 'L2 Switch' },
            { value: 'switch_l3', label: 'L3 Switch' },
            { value: 'router', label: 'Router' },
            { value: 'firewall', label: 'Firewall' },
            { value: 'loadbalancer', label: 'Load Balancer' },
            { value: 'wireless_ap', label: 'Kablosuz AP' },
            { value: 'wireless_controller', label: 'Kablosuz Kontrolcü' },
            
            // Depolama Sistemleri
            { value: 'storage_nas', label: 'NAS Storage' },
            { value: 'storage_san', label: 'SAN Storage' },
            { value: 'storage_backup', label: 'Yedekleme Ünitesi' },
            { value: 'storage_tape', label: 'Teyp Ünitesi' },
            
            // Sanallaştırma
            { value: 'hypervisor_host', label: 'Hipervizör Host' },
            { value: 'hypervisor_manager', label: 'Hipervizör Yönetici' },
            
            // Son Kullanıcı Cihazları
            { value: 'pc_desktop', label: 'Masaüstü Bilgisayar' },
            { value: 'pc_laptop', label: 'Dizüstü Bilgisayar' },
            { value: 'pc_workstation', label: 'İş İstasyonu' },
            { value: 'thin_client', label: 'İnce İstemci' },
            
            // Yazıcılar ve Tarayıcılar
            { value: 'printer_laser', label: 'Lazer Yazıcı' },
            { value: 'printer_inkjet', label: 'Mürekkep Püskürtmeli Yazıcı' },
            { value: 'printer_multi', label: 'Çok Fonksiyonlu Yazıcı' },
            { value: 'scanner', label: 'Tarayıcı' },
            
            // Güvenlik Sistemleri
            { value: 'camera_ip', label: 'IP Kamera' },
            { value: 'camera_nvr', label: 'NVR Kayıt Cihazı' },
            { value: 'access_control', label: 'Geçiş Kontrol Sistemi' },
            { value: 'alarm_system', label: 'Alarm Sistemi' },
            
            // UPS ve Güç Sistemleri
            { value: 'ups', label: 'Kesintisiz Güç Kaynağı' },
            { value: 'pdu', label: 'Güç Dağıtım Ünitesi' },
            { value: 'generator', label: 'Jeneratör' },
            
            // IoT ve Sensörler
            { value: 'sensor_temp', label: 'Sıcaklık Sensörü' },
            { value: 'sensor_humidity', label: 'Nem Sensörü' },
            { value: 'sensor_motion', label: 'Hareket Sensörü' },
            { value: 'iot_gateway', label: 'IoT Gateway' },
            
            // Diğer
            { value: 'kvm', label: 'KVM Switch' },
            { value: 'console', label: 'Konsol Sunucusu' },
            { value: 'other', label: 'Diğer' }
        ];

        // İşletim sistemi ve versiyonları için diziler
        const operatingSystems = [
            { 
                value: 'windows', 
                label: 'Windows',
                versions: [
                    // Windows Client
                    { value: 'win11_23h2', label: 'Windows 11 23H2' },
                    { value: 'win11_22h2', label: 'Windows 11 22H2' },
                    { value: 'win11_21h2', label: 'Windows 11 21H2' },
                    { value: 'win10_22h2', label: 'Windows 10 22H2' },
                    { value: 'win10_21h2', label: 'Windows 10 21H2' },
                    { value: 'win10_ltsc', label: 'Windows 10 LTSC 2021' },
                    { value: 'win8.1', label: 'Windows 8.1' },
                    { value: 'win8', label: 'Windows 8' },
                    { value: 'win7_sp1', label: 'Windows 7 SP1' },
                    { value: 'winxp_sp3', label: 'Windows XP SP3' },
                    // Windows Server
                    { value: 'win2022', label: 'Windows Server 2022' },
                    { value: 'win2019', label: 'Windows Server 2019' },
                    { value: 'win2016', label: 'Windows Server 2016' },
                    { value: 'win2012r2', label: 'Windows Server 2012 R2' },
                    { value: 'win2012', label: 'Windows Server 2012' },
                    { value: 'win2008r2', label: 'Windows Server 2008 R2' },
                    { value: 'win2008', label: 'Windows Server 2008' },
                    { value: 'win2003', label: 'Windows Server 2003' }
                ]
            },
            { 
                value: 'linux', 
                label: 'Linux',
                versions: [
                    // RHEL Based
                    { value: 'rhel9.3', label: 'Red Hat Enterprise Linux 9.3' },
                    { value: 'rhel8.9', label: 'Red Hat Enterprise Linux 8.9' },
                    { value: 'rhel7.9', label: 'Red Hat Enterprise Linux 7.9' },
                    { value: 'rocky9.3', label: 'Rocky Linux 9.3' },
                    { value: 'rocky8.9', label: 'Rocky Linux 8.9' },
                    { value: 'alma9.3', label: 'AlmaLinux 9.3' },
                    { value: 'alma8.9', label: 'AlmaLinux 8.9' },
                    { value: 'centos7', label: 'CentOS 7' },
                    // Debian Based
                    { value: 'debian12.4', label: 'Debian 12.4 (Bookworm)' },
                    { value: 'debian11.8', label: 'Debian 11.8 (Bullseye)' },
                    { value: 'debian10.13', label: 'Debian 10.13 (Buster)' },
                    { value: 'ubuntu22.04.3', label: 'Ubuntu 22.04.3 LTS' },
                    { value: 'ubuntu20.04.6', label: 'Ubuntu 20.04.6 LTS' },
                    { value: 'ubuntu18.04.6', label: 'Ubuntu 18.04.6 LTS' },
                    // SUSE Based
                    { value: 'sles15sp5', label: 'SUSE Linux Enterprise 15 SP5' },
                    { value: 'sles15sp4', label: 'SUSE Linux Enterprise 15 SP4' },
                    { value: 'sles12sp5', label: 'SUSE Linux Enterprise 12 SP5' },
                    { value: 'opensuse15.5', label: 'openSUSE Leap 15.5' },
                    // Others
                    { value: 'fedora39', label: 'Fedora 39' },
                    { value: 'fedora38', label: 'Fedora 38' },
                    { value: 'kali2023.4', label: 'Kali Linux 2023.4' },
                    { value: 'arch', label: 'Arch Linux' },
                    { value: 'gentoo', label: 'Gentoo Linux' },
                    { value: 'alpine3.19', label: 'Alpine Linux 3.19' }
                ]
            },
            { 
                value: 'vmware', 
                label: 'VMware',
                versions: [
                    // ESXi
                    { value: 'esxi8.0u2', label: 'VMware ESXi 8.0 Update 2' },
                    { value: 'esxi8.0u1', label: 'VMware ESXi 8.0 Update 1' },
                    { value: 'esxi8.0', label: 'VMware ESXi 8.0' },
                    { value: 'esxi7.0u3', label: 'VMware ESXi 7.0 Update 3' },
                    { value: 'esxi7.0u2', label: 'VMware ESXi 7.0 Update 2' },
                    { value: 'esxi6.7u3', label: 'VMware ESXi 6.7 Update 3' },
                    { value: 'esxi6.5u3', label: 'VMware ESXi 6.5 Update 3' },
                    // vCenter
                    { value: 'vcenter8.0u2', label: 'vCenter Server 8.0 Update 2' },
                    { value: 'vcenter8.0u1', label: 'vCenter Server 8.0 Update 1' },
                    { value: 'vcenter8.0', label: 'vCenter Server 8.0' },
                    { value: 'vcenter7.0u3', label: 'vCenter Server 7.0 Update 3' },
                    { value: 'vcenter6.7u3', label: 'vCenter Server 6.7 Update 3' },
                    // vSAN
                    { value: 'vsan8.0u2', label: 'vSAN 8.0 Update 2' },
                    { value: 'vsan8.0u1', label: 'vSAN 8.0 Update 1' },
                    { value: 'vsan8.0', label: 'vSAN 8.0' },
                    { value: 'vsan7.0u3', label: 'vSAN 7.0 Update 3' }
                ]
            },
            { 
                value: 'network', 
                label: 'Network OS',
                versions: [
                    // Cisco IOS
                    { value: 'ios17.12.1', label: 'Cisco IOS 17.12.1' },
                    { value: 'ios17.11.1', label: 'Cisco IOS 17.11.1' },
                    { value: 'ios17.10.1', label: 'Cisco IOS 17.10.1' },
                    { value: 'ios16.12.1', label: 'Cisco IOS 16.12.1' },
                    { value: 'ios15.7', label: 'Cisco IOS 15.7' },
                    // Cisco IOS XE
                    { value: 'iosxe17.12.1', label: 'Cisco IOS XE 17.12.1' },
                    { value: 'iosxe17.11.1', label: 'Cisco IOS XE 17.11.1' },
                    { value: 'iosxe17.10.1', label: 'Cisco IOS XE 17.10.1' },
                    { value: 'iosxe16.12.1', label: 'Cisco IOS XE 16.12.1' },
                    // Cisco NX-OS
                    { value: 'nxos10.3.2', label: 'Cisco NX-OS 10.3(2)' },
                    { value: 'nxos10.2.4', label: 'Cisco NX-OS 10.2(4)' },
                    { value: 'nxos10.1.2', label: 'Cisco NX-OS 10.1(2)' },
                    { value: 'nxos9.3.10', label: 'Cisco NX-OS 9.3(10)' },
                    // Mikrotik RouterOS
                    { value: 'ros7.13.4', label: 'RouterOS 7.13.4' },
                    { value: 'ros7.12', label: 'RouterOS 7.12' },
                    { value: 'ros6.49.10', label: 'RouterOS 6.49.10' },
                    { value: 'ros6.48.6', label: 'RouterOS 6.48.6' },
                    // Fortinet
                    { value: 'fos7.4.1', label: 'FortiOS 7.4.1' },
                    { value: 'fos7.2.6', label: 'FortiOS 7.2.6' },
                    { value: 'fos7.0.12', label: 'FortiOS 7.0.12' },
                    { value: 'fos6.4.12', label: 'FortiOS 6.4.12' },
                    // Palo Alto
                    { value: 'panos11.0', label: 'PAN-OS 11.0' },
                    { value: 'panos10.2', label: 'PAN-OS 10.2' },
                    { value: 'panos10.1', label: 'PAN-OS 10.1' },
                    // Juniper
                    { value: 'junos23.2', label: 'Juniper Junos 23.2' },
                    { value: 'junos23.1', label: 'Juniper Junos 23.1' },
                    { value: 'junos22.4', label: 'Juniper Junos 22.4' },
                    // Aruba
                    { value: 'arubaos8.11', label: 'ArubaOS 8.11' },
                    { value: 'arubaos8.10', label: 'ArubaOS 8.10' },
                    { value: 'arubaos8.9', label: 'ArubaOS 8.9' },
                    // Others
                    { value: 'pfsense23.09', label: 'pfSense Plus 23.09' },
                    { value: 'opnsense23.7.11', label: 'OPNsense 23.7.11' },
                    { value: 'vyos1.5', label: 'VyOS 1.5' },
                    { value: 'cumulus5.4', label: 'Cumulus Linux 5.4' },
                    { value: 'sonic4.1', label: 'SONiC 4.1' }
                ]
            },
            {
                value: 'storage', 
                label: 'Storage OS',
                versions: [
                    // NetApp ONTAP
                    { value: 'ontap9.12.1p4', label: 'NetApp ONTAP 9.12.1P4' },
                    { value: 'ontap9.11.1p12', label: 'NetApp ONTAP 9.11.1P12' },
                    { value: 'ontap9.10.1p15', label: 'NetApp ONTAP 9.10.1P15' },
                    { value: 'ontap9.9.1p35', label: 'NetApp ONTAP 9.9.1P35' },
                    // Dell EMC
                    { value: 'powerstore3.5', label: 'Dell PowerStore OS 3.5' },
                    { value: 'powerstore3.0', label: 'Dell PowerStore OS 3.0' },
                    { value: 'unity5.3', label: 'Dell Unity OE 5.3' },
                    { value: 'unity5.2', label: 'Dell Unity OE 5.2' },
                    { value: 'unityxt5.3', label: 'Dell Unity XT OE 5.3' },
                    // HPE
                    { value: 'nimble6.1', label: 'HPE Nimble OS 6.1' },
                    { value: 'nimble6.0', label: 'HPE Nimble OS 6.0' },
                    { value: '3par9.3', label: 'HPE 3PAR OS 9.3' },
                    { value: 'primera4.4', label: 'HPE Primera OS 4.4' },
                    // Pure Storage
                    { value: 'purity6.4', label: 'Pure Purity//FA 6.4' },
                    { value: 'purity6.3', label: 'Pure Purity//FA 6.3' },
                    { value: 'purityfb3.5', label: 'Pure Purity//FB 3.5' },
                    // IBM
                    { value: 'spectrum9.4', label: 'IBM Spectrum Virtualize 9.4' },
                    { value: 'spectrum9.3', label: 'IBM Spectrum Virtualize 9.3' },
                    { value: 'ds8900', label: 'IBM DS8900F R9.3' },
                    // Others
                    { value: 'truenas23.10', label: 'TrueNAS SCALE 23.10' },
                    { value: 'freenas13.0u5', label: 'FreeNAS 13.0-U5' },
                    { value: 'ceph18.2', label: 'Ceph Storage 18.2' }
                ]
            },
            {
                value: 'hypervisor',
                label: 'Hypervisor',
                versions: [
                    // Microsoft Hyper-V
                    { value: 'hyperv2022', label: 'Hyper-V Server 2022' },
                    { value: 'hyperv2019', label: 'Hyper-V Server 2019' },
                    { value: 'hyperv2016', label: 'Hyper-V Server 2016' },
                    // Citrix
                    { value: 'xenserver8.3', label: 'Citrix Hypervisor 8.3' },
                    { value: 'xenserver8.2', label: 'Citrix Hypervisor 8.2' },
                    { value: 'xenserver8.1', label: 'Citrix Hypervisor 8.1' },
                    // KVM
                    { value: 'kvm_rhel9', label: 'KVM on RHEL 9' },
                    { value: 'kvm_ubuntu22', label: 'KVM on Ubuntu 22.04' },
                    { value: 'kvm_sles15', label: 'KVM on SLES 15' },
                    // Proxmox
                    { value: 'proxmox8.0', label: 'Proxmox VE 8.0' },
                    { value: 'proxmox7.4', label: 'Proxmox VE 7.4' },
                    { value: 'proxmox7.3', label: 'Proxmox VE 7.3' },
                    // Oracle
                    { value: 'ovirt4.5', label: 'oVirt 4.5' },
                    { value: 'virtualbox7.0', label: 'VirtualBox 7.0' }
                ]
            },
            {
                value: 'other',
                label: 'Diğer',
                versions: [
                    { value: 'custom', label: 'Özel' },
                    { value: 'unknown', label: 'Bilinmiyor' },
                    { value: 'none', label: 'İşletim Sistemi Yok' },
                    { value: 'legacy', label: 'Eski Sistem' }
                ]
            }
        ];

        // Cihaz markaları ve modelleri için diziler
        const deviceBrands = [
            {
                value: 'dell',
                label: 'Dell',
                categories: ['server_physical', 'server_blade', 'pc_desktop', 'pc_laptop', 'pc_workstation', 'storage_san'],
                models: [
                    // Sunucular
                    { value: 'poweredge_r750', label: 'PowerEdge R750', type: 'server_physical' },
                    { value: 'poweredge_r650', label: 'PowerEdge R650', type: 'server_physical' },
                    { value: 'poweredge_r740', label: 'PowerEdge R740', type: 'server_physical' },
                    { value: 'poweredge_r730', label: 'PowerEdge R730', type: 'server_physical' },
                    { value: 'poweredge_r720', label: 'PowerEdge R720', type: 'server_physical' },
                    // Blade Sunucular
                    { value: 'poweredge_m640', label: 'PowerEdge M640', type: 'server_blade' },
                    { value: 'poweredge_m630', label: 'PowerEdge M630', type: 'server_blade' },
                    { value: 'poweredge_mx740c', label: 'PowerEdge MX740c', type: 'server_blade' },
                    // İş İstasyonları
                    { value: 'precision_7920', label: 'Precision 7920 Tower', type: 'pc_workstation' },
                    { value: 'precision_5820', label: 'Precision 5820 Tower', type: 'pc_workstation' },
                    { value: 'precision_3660', label: 'Precision 3660 Tower', type: 'pc_workstation' },
                    // Dizüstü
                    { value: 'latitude_5430', label: 'Latitude 5430', type: 'pc_laptop' },
                    { value: 'latitude_5530', label: 'Latitude 5530', type: 'pc_laptop' },
                    { value: 'precision_5570', label: 'Precision 5570', type: 'pc_laptop' },
                    { value: 'precision_7770', label: 'Precision 7770', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'optiplex_7090', label: 'OptiPlex 7090', type: 'pc_desktop' },
                    { value: 'optiplex_5090', label: 'OptiPlex 5090', type: 'pc_desktop' },
                    { value: 'optiplex_3090', label: 'OptiPlex 3090', type: 'pc_desktop' },
                    // Storage
                    { value: 'powervault_me4084', label: 'PowerVault ME4084', type: 'storage_san' },
                    { value: 'powervault_me4024', label: 'PowerVault ME4024', type: 'storage_san' }
                ]
            },
            {
                value: 'hp',
                label: 'HP',
                categories: ['server_physical', 'server_blade', 'pc_desktop', 'pc_laptop', 'pc_workstation', 'printer_laser', 'printer_inkjet', 'storage_san'],
                models: [
                    // Sunucular
                    { value: 'dl380_gen10plus', label: 'ProLiant DL380 Gen10 Plus', type: 'server_physical' },
                    { value: 'dl360_gen10plus', label: 'ProLiant DL360 Gen10 Plus', type: 'server_physical' },
                    { value: 'dl380_gen10', label: 'ProLiant DL380 Gen10', type: 'server_physical' },
                    { value: 'dl360_gen10', label: 'ProLiant DL360 Gen10', type: 'server_physical' },
                    { value: 'dl380_gen9', label: 'ProLiant DL380 Gen9', type: 'server_physical' },
                    // Blade Sunucular
                    { value: 'bl460c_gen10', label: 'ProLiant BL460c Gen10', type: 'server_blade' },
                    { value: 'bl460c_gen9', label: 'ProLiant BL460c Gen9', type: 'server_blade' },
                    // İş İstasyonları
                    { value: 'z6_g4', label: 'Z6 G4 Workstation', type: 'pc_workstation' },
                    { value: 'z4_g4', label: 'Z4 G4 Workstation', type: 'pc_workstation' },
                    { value: 'z2_g9', label: 'Z2 G9 Tower', type: 'pc_workstation' },
                    // Dizüstü
                    { value: 'elitebook_850g9', label: 'EliteBook 850 G9', type: 'pc_laptop' },
                    { value: 'elitebook_840g9', label: 'EliteBook 840 G9', type: 'pc_laptop' },
                    { value: 'zbook_fury_g9', label: 'ZBook Fury G9', type: 'pc_laptop' },
                    { value: 'zbook_power_g9', label: 'ZBook Power G9', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'elitedesk_800g9', label: 'EliteDesk 800 G9', type: 'pc_desktop' },
                    { value: 'prodesk_600g9', label: 'ProDesk 600 G9', type: 'pc_desktop' },
                    // Yazıcılar
                    { value: 'laserjet_e60175', label: 'LaserJet E60175', type: 'printer_laser' },
                    { value: 'laserjet_m507', label: 'LaserJet Enterprise M507', type: 'printer_laser' },
                    { value: 'officejet_9020e', label: 'OfficeJet Pro 9020e', type: 'printer_inkjet' },
                    { value: 'officejet_9025e', label: 'OfficeJet Pro 9025e', type: 'printer_inkjet' },
                    // Storage
                    { value: 'msa_2060', label: 'MSA 2060 Storage', type: 'storage_san' },
                    { value: 'msa_2050', label: 'MSA 2050 Storage', type: 'storage_san' }
                ]
            },
            {
                value: 'lenovo',
                label: 'Lenovo',
                categories: ['server_physical', 'server_blade', 'pc_desktop', 'pc_laptop', 'pc_workstation'],
                models: [
                    // Sunucular
                    { value: 'sr650_v2', label: 'ThinkSystem SR650 V2', type: 'server_physical' },
                    { value: 'sr630_v2', label: 'ThinkSystem SR630 V2', type: 'server_physical' },
                    { value: 'sr550', label: 'ThinkSystem SR550', type: 'server_physical' },
                    // Blade Sunucular
                    { value: 'sh450_v2', label: 'ThinkSystem SH450 V2', type: 'server_blade' },
                    // İş İstasyonları
                    { value: 'p620', label: 'ThinkStation P620', type: 'pc_workstation' },
                    { value: 'p520', label: 'ThinkStation P520', type: 'pc_workstation' },
                    // Dizüstü
                    { value: 'thinkpad_p1g5', label: 'ThinkPad P1 Gen5', type: 'pc_laptop' },
                    { value: 'thinkpad_t14g3', label: 'ThinkPad T14 Gen3', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'thinkcentre_m70t', label: 'ThinkCentre M70t', type: 'pc_desktop' },
                    { value: 'thinkcentre_m90t', label: 'ThinkCentre M90t', type: 'pc_desktop' }
                ]
            },
            {
                value: 'cisco',
                label: 'Cisco',
                categories: ['switch_l2', 'switch_l3', 'router', 'firewall', 'wireless_ap', 'wireless_controller'],
                models: [
                    // L3 Switchler
                    { value: 'c9500_48y4c', label: 'Catalyst 9500-48Y4C', type: 'switch_l3' },
                    { value: 'c9500_32c', label: 'Catalyst 9500-32C', type: 'switch_l3' },
                    { value: 'c9300_48p', label: 'Catalyst 9300-48P', type: 'switch_l3' },
                    { value: 'c9300_24p', label: 'Catalyst 9300-24P', type: 'switch_l3' },
                    // L2 Switchler
                    { value: 'c9200_48p', label: 'Catalyst 9200-48P', type: 'switch_l2' },
                    { value: 'c9200_24p', label: 'Catalyst 9200-24P', type: 'switch_l2' },
                    // Routerlar
                    { value: 'isr_4451', label: 'ISR 4451-X', type: 'router' },
                    { value: 'isr_4431', label: 'ISR 4431-X', type: 'router' },
                    { value: 'asr_1001hx', label: 'ASR 1001-HX', type: 'router' },
                    { value: 'asr_1002hx', label: 'ASR 1002-HX', type: 'router' },
                    // Firewall
                    { value: 'asa_5545x', label: 'ASA 5545-X', type: 'firewall' },
                    { value: 'ftd_2130', label: 'Firepower 2130', type: 'firewall' },
                    { value: 'ftd_2140', label: 'Firepower 2140', type: 'firewall' },
                    // Wireless
                    { value: 'air_9130', label: 'Aironet 9130', type: 'wireless_ap' },
                    { value: 'air_9120', label: 'Aironet 9120', type: 'wireless_ap' },
                    { value: 'air_9115', label: 'Aironet 9115', type: 'wireless_ap' },
                    // Wireless Controller
                    { value: 'wlc_9800_40', label: 'Catalyst 9800-40', type: 'wireless_controller' },
                    { value: 'wlc_9800_80', label: 'Catalyst 9800-80', type: 'wireless_controller' }
                ]
            },
            {
                value: 'fortinet',
                label: 'Fortinet',
                categories: ['firewall', 'switch_l2', 'switch_l3', 'wireless_ap', 'wireless_controller'],
                models: [
                    // Firewall
                    { value: 'fg_100f', label: 'FortiGate 100F', type: 'firewall' },
                    { value: 'fg_200f', label: 'FortiGate 200F', type: 'firewall' },
                    { value: 'fg_400f', label: 'FortiGate 400F', type: 'firewall' },
                    { value: 'fg_600f', label: 'FortiGate 600F', type: 'firewall' },
                    { value: 'fg_1100e', label: 'FortiGate 1100E', type: 'firewall' },
                    // L3 Switch
                    { value: 'fs_548d', label: 'FortiSwitch 548D', type: 'switch_l3' },
                    { value: 'fs_524d', label: 'FortiSwitch 524D', type: 'switch_l3' },
                    // L2 Switch
                    { value: 'fs_448d', label: 'FortiSwitch 448D', type: 'switch_l2' },
                    { value: 'fs_424d', label: 'FortiSwitch 424D', type: 'switch_l2' },
                    // Wireless AP
                    { value: 'fap_431f', label: 'FortiAP 431F', type: 'wireless_ap' },
                    { value: 'fap_231f', label: 'FortiAP 231F', type: 'wireless_ap' },
                    { value: 'fap_221e', label: 'FortiAP 221E', type: 'wireless_ap' },
                    // Wireless Controller
                    { value: 'fwc_50e', label: 'FortiWLC 50E', type: 'wireless_controller' },
                    { value: 'fwc_200f', label: 'FortiWLC 200F', type: 'wireless_controller' }
                ]
            },
            {
                value: 'paloalto',
                label: 'Palo Alto Networks',
                categories: ['firewall'],
                models: [
                    { value: 'pa_820', label: 'PA-820', type: 'firewall' },
                    { value: 'pa_850', label: 'PA-850', type: 'firewall' },
                    { value: 'pa_3220', label: 'PA-3220', type: 'firewall' },
                    { value: 'pa_3260', label: 'PA-3260', type: 'firewall' },
                    { value: 'pa_5220', label: 'PA-5220', type: 'firewall' },
                    { value: 'pa_5250', label: 'PA-5250', type: 'firewall' }
                ]
            },
            {
                value: 'juniper',
                label: 'Juniper Networks',
                categories: ['switch_l2', 'switch_l3', 'router', 'firewall'],
                models: [
                    // L3 Switch
                    { value: 'ex4650', label: 'EX4650', type: 'switch_l3' },
                    { value: 'ex4600', label: 'EX4600', type: 'switch_l3' },
                    // L2 Switch
                    { value: 'ex2300', label: 'EX2300', type: 'switch_l2' },
                    { value: 'ex3400', label: 'EX3400', type: 'switch_l2' },
                    // Router
                    { value: 'mx204', label: 'MX204', type: 'router' },
                    { value: 'mx240', label: 'MX240', type: 'router' },
                    // Firewall
                    { value: 'srx340', label: 'SRX340', type: 'firewall' },
                    { value: 'srx380', label: 'SRX380', type: 'firewall' }
                ]
            },
            {
                value: 'huawei',
                label: 'Huawei',
                categories: ['switch_l2', 'switch_l3', 'router', 'firewall', 'storage_san'],
                models: [
                    // Switchler
                    { value: 's5735_l', label: 'S5735-L Series', type: 'switch_l2' },
                    { value: 's6730_h', label: 'S6730-H Series', type: 'switch_l3' },
                    { value: 's7700', label: 'S7700 Series', type: 'switch_l3' },
                    // Routerlar
                    { value: 'ar6120', label: 'AR6120', type: 'router' },
                    { value: 'ar6280', label: 'AR6280', type: 'router' },
                    { value: 'ne40e', label: 'NetEngine 40E', type: 'router' },
                    // Firewall
                    { value: 'usg6600e', label: 'USG6600E', type: 'firewall' },
                    { value: 'usg6700e', label: 'USG6700E', type: 'firewall' },
                    // Storage
                    { value: 'oceanstor_5300', label: 'OceanStor 5300 V5', type: 'storage_san' },
                    { value: 'oceanstor_5500', label: 'OceanStor 5500 V5', type: 'storage_san' }
                ]
            },
            {
                value: 'arista',
                label: 'Arista',
                categories: ['switch_l2', 'switch_l3'],
                models: [
                    { value: '7050x3', label: '7050X3 Series', type: 'switch_l3' },
                    { value: '7060x4', label: '7060X4 Series', type: 'switch_l3' },
                    { value: '7280r3', label: '7280R3 Series', type: 'switch_l3' },
                    { value: '7300x3', label: '7300X3 Series', type: 'switch_l3' }
                ]
            },
            {
                value: 'hpe_aruba',
                label: 'HPE Aruba',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap', 'wireless_controller'],
                models: [
                    // Switchler
                    { value: 'cx6400', label: 'CX 6400 Switch Series', type: 'switch_l3' },
                    { value: 'cx8400', label: 'CX 8400 Switch Series', type: 'switch_l3' },
                    { value: 'cx6200', label: 'CX 6200 Switch Series', type: 'switch_l2' },
                    // Wireless
                    { value: 'ap635', label: 'AP-635', type: 'wireless_ap' },
                    { value: 'ap655', label: 'AP-655', type: 'wireless_ap' },
                    { value: 'ap575', label: 'AP-575', type: 'wireless_ap' },
                    { value: '9000', label: 'Mobility Controller 9000', type: 'wireless_controller' }
                ]
            },
            {
                value: 'extreme',
                label: 'Extreme Networks',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap', 'wireless_controller'],
                models: [
                    { value: '5520', label: '5520 Series', type: 'switch_l3' },
                    { value: '5420', label: '5420 Series', type: 'switch_l2' },
                    { value: 'ap410c', label: 'AP410C', type: 'wireless_ap' },
                    { value: 'ap460c', label: 'AP460C', type: 'wireless_ap' }
                ]
            },
            {
                value: 'synology',
                label: 'Synology',
                categories: ['storage_nas', 'storage_backup'],
                models: [
                    { value: 'rs4021xs', label: 'RackStation RS4021xs+', type: 'storage_nas' },
                    { value: 'rs3621xs', label: 'RackStation RS3621xs+', type: 'storage_nas' },
                    { value: 'sa3600', label: 'SA3600', type: 'storage_nas' },
                    { value: 'rs1221', label: 'RackStation RS1221+', type: 'storage_nas' }
                ]
            },
            {
                value: 'qnap',
                label: 'QNAP',
                categories: ['storage_nas', 'storage_backup'],
                models: [
                    { value: 'ts1677', label: 'TS-1677XU-RP', type: 'storage_nas' },
                    { value: 'ts983', label: 'TS-983XU-RP', type: 'storage_nas' },
                    { value: 'tvs972', label: 'TVS-972XU-RP', type: 'storage_nas' }
                ]
            },
            {
                value: 'netapp',
                label: 'NetApp',
                categories: ['storage_san', 'storage_nas'],
                models: [
                    { value: 'aff_a250', label: 'AFF A250', type: 'storage_san' },
                    { value: 'aff_a400', label: 'AFF A400', type: 'storage_san' },
                    { value: 'fas2750', label: 'FAS2750', type: 'storage_san' },
                    { value: 'fas8300', label: 'FAS8300', type: 'storage_san' }
                ]
            },
            {
                value: 'checkpoint',
                label: 'Check Point',
                categories: ['firewall'],
                models: [
                    { value: '3600', label: '3600 Appliance', type: 'firewall' },
                    { value: '3800', label: '3800 Appliance', type: 'firewall' },
                    { value: '6200', label: '6200 Appliance', type: 'firewall' },
                    { value: '6600', label: '6600 Appliance', type: 'firewall' }
                ]
            },
            {
                value: 'sophos',
                label: 'Sophos',
                categories: ['firewall'],
                models: [
                    { value: 'xgs3300', label: 'XGS 3300', type: 'firewall' },
                    { value: 'xgs4300', label: 'XGS 4300', type: 'firewall' },
                    { value: 'xgs5500', label: 'XGS 5500', type: 'firewall' }
                ]
            },
            {
                value: 'apc',
                label: 'APC',
                categories: ['ups', 'pdu'],
                models: [
                    { value: 'srt5kxli', label: 'Smart-UPS SRT 5000VA', type: 'ups' },
                    { value: 'srt6kxli', label: 'Smart-UPS SRT 6000VA', type: 'ups' },
                    { value: 'ap8953', label: 'Rack PDU 2G', type: 'pdu' },
                    { value: 'ap8959', label: 'Rack PDU 2G Switched', type: 'pdu' }
                ]
            },
            {
                value: 'eaton',
                label: 'Eaton',
                categories: ['ups', 'pdu'],
                models: [
                    { value: '9px6ki', label: '9PX 6000i RT3U', type: 'ups' },
                    { value: '9px8ki', label: '9PX 8000i RT6U', type: 'ups' },
                    { value: 'epdu', label: 'ePDU G3 Managed', type: 'pdu' }
                ]
            },
            {
                value: 'vertiv',
                label: 'Vertiv',
                categories: ['ups', 'pdu'],
                models: [
                    { value: 'gxt5_5k', label: 'Liebert GXT5 5kVA', type: 'ups' },
                    { value: 'gxt5_10k', label: 'Liebert GXT5 10kVA', type: 'ups' },
                    { value: 'mpx', label: 'MPX Rack PDU', type: 'pdu' },
                    { value: 'mphr', label: 'MPH2 Rack PDU', type: 'pdu' }
                ]
            },
            {
                value: 'zyxel',
                label: 'Zyxel',
                categories: ['switch_l2', 'switch_l3', 'firewall', 'wireless_ap', 'wireless_controller'],
                models: [
                    // Switchler
                    { value: 'xgs4728f', label: 'XGS4728F', type: 'switch_l3' },
                    { value: 'xgs3700', label: 'XGS3700 Series', type: 'switch_l3' },
                    { value: 'gs2220', label: 'GS2220 Series', type: 'switch_l2' },
                    // Firewall
                    { value: 'atp800', label: 'ATP800', type: 'firewall' },
                    { value: 'usg2200', label: 'USG2200', type: 'firewall' },
                    // Wireless
                    { value: 'wax650s', label: 'WAX650S', type: 'wireless_ap' },
                    { value: 'nxc5500', label: 'NXC5500', type: 'wireless_controller' }
                ]
            },
            {
                value: 'ubiquiti',
                label: 'Ubiquiti',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap', 'wireless_controller'],
                models: [
                    { value: 'usw_pro_48', label: 'UniFi Switch Pro 48', type: 'switch_l3' },
                    { value: 'usw_24_poe', label: 'UniFi Switch 24 PoE', type: 'switch_l2' },
                    { value: 'u6_pro', label: 'UniFi 6 Pro', type: 'wireless_ap' },
                    { value: 'udm_pro', label: 'UniFi Dream Machine Pro', type: 'wireless_controller' }
                ]
            },
            {
                value: 'tplink',
                label: 'TP-Link',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap', 'router'],
                models: [
                    { value: 't3700g', label: 'T3700G-28TQ', type: 'switch_l3' },
                    { value: 'tl_sg3428x', label: 'TL-SG3428X', type: 'switch_l2' },
                    { value: 'eap670', label: 'EAP670', type: 'wireless_ap' },
                    { value: 'er7206', label: 'ER7206', type: 'router' }
                ]
            },
            {
                value: 'dlink',
                label: 'D-Link',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap'],
                models: [
                    { value: 'dgs_3630', label: 'DGS-3630 Series', type: 'switch_l3' },
                    { value: 'dgs_1520', label: 'DGS-1520 Series', type: 'switch_l2' },
                    { value: 'dap_2680', label: 'DAP-2680', type: 'wireless_ap' }
                ]
            },
            {
                value: 'fujitsu',
                label: 'Fujitsu',
                categories: ['server_physical', 'server_blade', 'storage_san'],
                models: [
                    { value: 'rx2540_m6', label: 'PRIMERGY RX2540 M6', type: 'server_physical' },
                    { value: 'rx4770_m6', label: 'PRIMERGY RX4770 M6', type: 'server_physical' },
                    { value: 'bx2580_m2', label: 'PRIMERGY BX2580 M2', type: 'server_blade' },
                    { value: 'eternus_dx100', label: 'ETERNUS DX100 S5', type: 'storage_san' }
                ]
            },
            {
                value: 'supermicro',
                label: 'Supermicro',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'sys_6019p', label: 'SuperServer 6019P-WT', type: 'server_physical' },
                    { value: 'sys_2049u', label: 'SuperServer 2049U-TR4', type: 'server_physical' },
                    { value: 'sys_blade', label: 'SuperBlade Series', type: 'server_blade' }
                ]
            },
            {
                value: 'hikvision',
                label: 'Hikvision',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'ds2cd2385g1', label: 'DS-2CD2385G1-I', type: 'camera_ip' },
                    { value: 'ds2cd2755g1', label: 'DS-2CD2755G1-IZS', type: 'camera_ip' },
                    { value: 'ds7716ni', label: 'DS-7716NI-K4', type: 'camera_nvr' }
                ]
            },
            {
                value: 'axis',
                label: 'Axis Communications',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'p3375', label: 'P3375-V', type: 'camera_ip' },
                    { value: 'q3538', label: 'Q3538-LVE', type: 'camera_ip' },
                    { value: 's1148', label: 'S1148 Recorder', type: 'camera_nvr' }
                ]
            },
            {
                value: 'brother',
                label: 'Brother',
                categories: ['printer_laser', 'printer_inkjet', 'printer_multi', 'scanner'],
                models: [
                    { value: 'hl_l6400dw', label: 'HL-L6400DW', type: 'printer_laser' },
                    { value: 'mfc_l9570cdw', label: 'MFC-L9570CDW', type: 'printer_multi' },
                    { value: 'ads_2800w', label: 'ADS-2800W', type: 'scanner' }
                ]
            },
            {
                value: 'epson',
                label: 'Epson',
                categories: ['printer_inkjet', 'printer_multi', 'scanner'],
                models: [
                    { value: 'wf_c20600', label: 'WorkForce Pro WF-C20600', type: 'printer_inkjet' },
                    { value: 'wf_c21000', label: 'WorkForce Enterprise WF-C21000', type: 'printer_multi' },
                    { value: 'ds_32000', label: 'DS-32000', type: 'scanner' }
                ]
            },
            {
                value: 'zebra',
                label: 'Zebra',
                categories: ['printer_laser', 'printer_multi'],
                models: [
                    { value: 'zt411', label: 'ZT411', type: 'printer_laser' },
                    { value: 'zt610', label: 'ZT610', type: 'printer_laser' },
                    { value: 'zd621', label: 'ZD621', type: 'printer_multi' }
                ]
            },
            {
                value: 'rittal',
                label: 'Rittal',
                categories: ['pdu'],
                models: [
                    { value: 'pdu_basic', label: 'PDU Basic', type: 'pdu' },
                    { value: 'pdu_metered', label: 'PDU Metered', type: 'pdu' },
                    { value: 'pdu_managed', label: 'PDU Managed', type: 'pdu' }
                ]
            },
            {
                value: 'panduit',
                label: 'Panduit',
                categories: ['pdu'],
                models: [
                    { value: 'pdu_basic_v', label: 'Basic Vertical PDU', type: 'pdu' },
                    { value: 'pdu_smart_v', label: 'Smart Vertical PDU', type: 'pdu' }
                ]
            },
            {
                value: 'honeywell',
                label: 'Honeywell',
                categories: ['sensor_temp', 'sensor_humidity', 'sensor_motion', 'access_control'],
                models: [
                    { value: 't775b', label: 'T775B Temperature Controller', type: 'sensor_temp' },
                    { value: 'h7080b', label: 'H7080B Humidity Sensor', type: 'sensor_humidity' },
                    { value: 'dx4010', label: 'DX4010 Motion Sensor', type: 'sensor_motion' },
                    { value: 'netaxs123', label: 'NetAXS-123', type: 'access_control' }
                ]
            },
            {
                value: 'schneider',
                label: 'Schneider Electric',
                categories: ['sensor_temp', 'sensor_humidity', 'ups', 'pdu'],
                models: [
                    { value: 'powertag', label: 'PowerTag Sensor', type: 'sensor_temp' },
                    { value: 'sm6000', label: 'SM6000 Monitor', type: 'sensor_humidity' },
                    { value: 'smart_ups_x', label: 'Smart-UPS X Series', type: 'ups' },
                    { value: 'ap8000', label: 'AP8000 Series PDU', type: 'pdu' }
                ]
            },
            {
                value: 'dahua',
                label: 'Dahua',
                categories: ['camera_ip', 'camera_nvr', 'access_control'],
                models: [
                    { value: 'ipc_hfw5541e', label: 'IPC-HFW5541E-ZE', type: 'camera_ip' },
                    { value: 'ipc_hdw3441', label: 'IPC-HDW3441EM-AS', type: 'camera_ip' },
                    { value: 'nvr5432', label: 'NVR5432-4KS2', type: 'camera_nvr' },
                    { value: 'nvr4432', label: 'NVR4432-4K', type: 'camera_nvr' },
                    { value: 'asc1202c', label: 'ASC1202C', type: 'access_control' }
                ]
            },
            {
                value: 'bosch',
                label: 'Bosch',
                categories: ['camera_ip', 'camera_nvr', 'access_control', 'sensor_motion', 'alarm_system'],
                models: [
                    { value: 'nde_8504', label: 'FLEXIDOME IP 8000i', type: 'camera_ip' },
                    { value: 'nbn_73023', label: 'DINION IP starlight 7000', type: 'camera_ip' },
                    { value: 'divar_5000', label: 'DIVAR network 5000', type: 'camera_nvr' },
                    { value: 'b8512g', label: 'B8512G Control Panel', type: 'alarm_system' },
                    { value: 'b6512', label: 'B6512 Control Panel', type: 'alarm_system' },
                    { value: 'ds160', label: 'DS160 Motion Detector', type: 'sensor_motion' }
                ]
            },
            {
                value: 'mobotix',
                label: 'Mobotix',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'm73', label: 'M73 AllroundDual', type: 'camera_ip' },
                    { value: 's74', label: 'S74 DualMount', type: 'camera_ip' },
                    { value: 'move_vr', label: 'MOVE VR-64', type: 'camera_nvr' }
                ]
            },
            {
                value: 'avigilon',
                label: 'Avigilon',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'h5a_dome', label: 'H5A Dome', type: 'camera_ip' },
                    { value: 'h5m_dome', label: 'H5M Dome', type: 'camera_ip' },
                    { value: 'nvr4_std', label: 'NVR4 Standard', type: 'camera_nvr' }
                ]
            },
            {
                value: 'hanwha',
                label: 'Hanwha Techwin',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'xnp_6400', label: 'XNP-6400', type: 'camera_ip' },
                    { value: 'qnp_6230', label: 'QNP-6230', type: 'camera_ip' },
                    { value: 'prn_4011', label: 'PRN-4011', type: 'camera_nvr' }
                ]
            },
            {
                value: 'johnson',
                label: 'Johnson Controls',
                categories: ['sensor_temp', 'sensor_humidity', 'access_control'],
                models: [
                    { value: 'te_6100', label: 'TE-6100 Series', type: 'sensor_temp' },
                    { value: 'hw_6100', label: 'HW-6100 Series', type: 'sensor_humidity' },
                    { value: 'p2000', label: 'P2000 Access Control', type: 'access_control' }
                ]
            },
            {
                value: 'lenel',
                label: 'LenelS2',
                categories: ['access_control'],
                models: [
                    { value: 'ngp_1320', label: 'NGP-1320', type: 'access_control' },
                    { value: 'ngp_2220', label: 'NGP-2220', type: 'access_control' },
                    { value: 'lnl_4420', label: 'LNL-4420', type: 'access_control' }
                ]
            },
            {
                value: 'idteck',
                label: 'IDTECK',
                categories: ['access_control'],
                models: [
                    { value: 'itdc_sr', label: 'ITDC-SR Series', type: 'access_control' },
                    { value: 'itdc_fp', label: 'ITDC-FP Series', type: 'access_control' }
                ]
            },
            {
                value: 'omega',
                label: 'Omega Engineering',
                categories: ['sensor_temp', 'sensor_humidity'],
                models: [
                    { value: 'om_dp32pt', label: 'DP32PT Controller', type: 'sensor_temp' },
                    { value: 'om_rh850', label: 'RH850 Series', type: 'sensor_humidity' }
                ]
            },
            {
                value: 'dwyer',
                label: 'Dwyer Instruments',
                categories: ['sensor_temp', 'sensor_humidity', 'sensor_motion'],
                models: [
                    { value: 'rht_d', label: 'RHT-D Series', type: 'sensor_temp' },
                    { value: 'thp_d', label: 'THP-D Series', type: 'sensor_humidity' },
                    { value: 'pms_d', label: 'PMS-D Series', type: 'sensor_motion' }
                ]
            },
            {
                value: 'raritan',
                label: 'Raritan',
                categories: ['pdu', 'kvm'],
                models: [
                    { value: 'px3_5000', label: 'PX3-5000 Series', type: 'pdu' },
                    { value: 'px3_4000', label: 'PX3-4000 Series', type: 'pdu' },
                    { value: 'dkx3_108', label: 'Dominion KX III-108', type: 'kvm' },
                    { value: 'dkx3_116', label: 'Dominion KX III-116', type: 'kvm' }
                ]
            },
            {
                value: 'tripp_lite',
                label: 'Tripp Lite',
                categories: ['ups', 'pdu', 'kvm'],
                models: [
                    { value: 'su6000rt4u', label: 'SU6000RT4U', type: 'ups' },
                    { value: 'su8000rt4u', label: 'SU8000RT4U', type: 'ups' },
                    { value: 'pdumv20', label: 'PDUMV20', type: 'pdu' },
                    { value: 'b064_016_ip', label: 'B064-016-IP', type: 'kvm' }
                ]
            },
            {
                value: 'aten',
                label: 'ATEN',
                categories: ['kvm'],
                models: [
                    { value: 'kn4116va', label: 'KN4116VA', type: 'kvm' },
                    { value: 'kn8132v', label: 'KN8132V', type: 'kvm' },
                    { value: 'kn4164v', label: 'KN4164V', type: 'kvm' }
                ]
            },
            {
                value: 'avtech',
                label: 'AVTECH',
                categories: ['sensor_temp', 'sensor_humidity', 'sensor_motion'],
                models: [
                    { value: 'room_alert_12e', label: 'Room Alert 12E', type: 'sensor_temp' },
                    { value: 'room_alert_32e', label: 'Room Alert 32E', type: 'sensor_humidity' },
                    { value: 'room_alert_4e', label: 'Room Alert 4E', type: 'sensor_motion' }
                ]
            },
            {
                value: 'geist',
                label: 'Geist',
                categories: ['sensor_temp', 'sensor_humidity', 'pdu'],
                models: [
                    { value: 'watchdog_15', label: 'Watchdog 15', type: 'sensor_temp' },
                    { value: 'watchdog_100', label: 'Watchdog 100', type: 'sensor_humidity' },
                    { value: 'upgr3i', label: 'UPGR3I', type: 'pdu' }
                ]
            },
            {
                value: 'samsung',
                label: 'Samsung',
                categories: ['camera_ip', 'camera_nvr', 'printer_laser', 'printer_multi'],
                models: [
                    { value: 'pnm_9081vrp', label: 'PNM-9081VRP', type: 'camera_ip' },
                    { value: 'xnp_6400rw', label: 'XNP-6400RW', type: 'camera_ip' },
                    { value: 'prn_4012', label: 'PRN-4012 NVR', type: 'camera_nvr' },
                    { value: 'sl_m4580fx', label: 'ProXpress M4580FX', type: 'printer_laser' },
                    { value: 'sl_x4300lx', label: 'MultiXpress X4300LX', type: 'printer_multi' }
                ]
            },
            {
                value: 'vivotek',
                label: 'Vivotek',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'fd9389_h', label: 'FD9389-H', type: 'camera_ip' },
                    { value: 'ib9389_h', label: 'IB9389-H', type: 'camera_ip' },
                    { value: 'nd9425hw', label: 'ND9425HW', type: 'camera_ip' },
                    { value: 'nd9322p', label: 'ND9322P NVR', type: 'camera_nvr' }
                ]
            },
            {
                value: 'grandstream',
                label: 'Grandstream',
                categories: ['camera_ip', 'camera_nvr'],
                models: [
                    { value: 'gxv3674', label: 'GXV3674 HD', type: 'camera_ip' },
                    { value: 'gxv3610', label: 'GXV3610 FHD', type: 'camera_ip' },
                    { value: 'gvr3552', label: 'GVR3552 NVR', type: 'camera_nvr' }
                ]
            },
            {
                value: 'kyocera',
                label: 'Kyocera',
                categories: ['printer_laser', 'printer_multi'],
                models: [
                    { value: 'ecosys_p3155dn', label: 'ECOSYS P3155dn', type: 'printer_laser' },
                    { value: 'ecosys_p3260dn', label: 'ECOSYS P3260dn', type: 'printer_laser' },
                    { value: 'taskalfa_4054ci', label: 'TASKalfa 4054ci', type: 'printer_multi' },
                    { value: 'taskalfa_5054ci', label: 'TASKalfa 5054ci', type: 'printer_multi' }
                ]
            },
            {
                value: 'ricoh',
                label: 'Ricoh',
                categories: ['printer_laser', 'printer_multi', 'scanner'],
                models: [
                    { value: 'p502', label: 'P 502', type: 'printer_laser' },
                    { value: 'im_c4500', label: 'IM C4500', type: 'printer_multi' },
                    { value: 'im_c6000', label: 'IM C6000', type: 'printer_multi' },
                    { value: 'is760', label: 'IS760 Scanner', type: 'scanner' }
                ]
            },
            {
                value: 'xerox',
                label: 'Xerox',
                categories: ['printer_laser', 'printer_multi'],
                models: [
                    { value: 'versalink_c7000', label: 'VersaLink C7000', type: 'printer_laser' },
                    { value: 'versalink_b7035', label: 'VersaLink B7035', type: 'printer_laser' },
                    { value: 'altalink_c8170', label: 'AltaLink C8170', type: 'printer_multi' }
                ]
            },
            {
                value: 'konica',
                label: 'Konica Minolta',
                categories: ['printer_laser', 'printer_multi'],
                models: [
                    { value: 'bizhub_c450i', label: 'bizhub C450i', type: 'printer_multi' },
                    { value: 'bizhub_c550i', label: 'bizhub C550i', type: 'printer_multi' },
                    { value: 'bizhub_c650i', label: 'bizhub C650i', type: 'printer_multi' }
                ]
            },
            {
                value: 'fujitsu_scanner',
                label: 'Fujitsu Scanner',
                categories: ['scanner'],
                models: [
                    { value: 'fi_7160', label: 'fi-7160', type: 'scanner' },
                    { value: 'fi_7300nx', label: 'fi-7300NX', type: 'scanner' },
                    { value: 'fi_7900', label: 'fi-7900', type: 'scanner' },
                    { value: 'sp_1425', label: 'SP-1425', type: 'scanner' }
                ]
            },
            {
                value: 'canon',
                label: 'Canon',
                categories: ['printer_laser', 'printer_inkjet', 'printer_multi', 'scanner'],
                models: [
                    { value: 'lbp228x', label: 'i-SENSYS LBP228x', type: 'printer_laser' },
                    { value: 'mf449x', label: 'i-SENSYS MF449x', type: 'printer_multi' },
                    { value: 'dr_g2110', label: 'DR-G2110 Scanner', type: 'scanner' }
                ]
            },
            {
                value: 'emerson',
                label: 'Emerson Network Power',
                categories: ['ups', 'pdu'],
                models: [
                    { value: 'gxt5_5000irt5u', label: 'Liebert GXT5-5000IRT5U', type: 'ups' },
                    { value: 'gxt5_6000irt5u', label: 'Liebert GXT5-6000IRT5U', type: 'ups' },
                    { value: 'mpe20_10', label: 'MPE20-10 PDU', type: 'pdu' },
                    { value: 'mpe30_16', label: 'MPE30-16 PDU', type: 'pdu' }
                ]
            },
            {
                value: 'delta',
                label: 'Delta',
                categories: ['ups'],
                models: [
                    { value: 'rt_6k', label: 'RT Series 6kVA', type: 'ups' },
                    { value: 'rt_10k', label: 'RT Series 10kVA', type: 'ups' },
                    { value: 'nh_20k', label: 'NH Plus Series 20kVA', type: 'ups' }
                ]
            },
            {
                value: 'socomec',
                label: 'Socomec',
                categories: ['ups', 'pdu'],
                models: [
                    { value: 'itys_6k', label: 'ITYS 6kVA', type: 'ups' },
                    { value: 'masterys_10k', label: 'MASTERYS 10kVA', type: 'ups' },
                    { value: 'pdu_rack', label: 'PDU RACK', type: 'pdu' }
                ]
            },
            {
                value: 'alcatel',
                label: 'Alcatel-Lucent Enterprise',
                categories: ['switch_l2', 'switch_l3', 'wireless_ap'],
                models: [
                    { value: 'os6900', label: 'OmniSwitch 6900', type: 'switch_l3' },
                    { value: 'os6860', label: 'OmniSwitch 6860', type: 'switch_l3' },
                    { value: 'os6465', label: 'OmniSwitch 6465', type: 'switch_l2' },
                    { value: 'oaw510', label: 'OmniAccess AP510', type: 'wireless_ap' }
                ]
            },
            {
                value: 'mellanox',
                label: 'Mellanox/NVIDIA',
                categories: ['switch_l2', 'switch_l3'],
                models: [
                    { value: 'sn4700', label: 'Spectrum-3 SN4700', type: 'switch_l3' },
                    { value: 'sn3700', label: 'Spectrum-2 SN3700', type: 'switch_l3' },
                    { value: 'sn2700', label: 'Spectrum SN2700', type: 'switch_l2' }
                ]
            },
            {
                value: 'intel',
                label: 'Intel',
                categories: ['server_physical', 'pc_workstation', 'pc_desktop'],
                models: [
                    { value: 'm50cyl', label: 'Server System M50CYL', type: 'server_physical' },
                    { value: 'r2308', label: 'Server System R2308', type: 'server_physical' },
                    { value: 'nuc12pro', label: 'NUC 12 Pro', type: 'pc_desktop' }
                ]
            },
            {
                value: 'amd',
                label: 'AMD',
                categories: ['server_physical'],
                models: [
                    { value: 'epyc_7003', label: 'EPYC 7003 Server', type: 'server_physical' },
                    { value: 'epyc_7002', label: 'EPYC 7002 Server', type: 'server_physical' }
                ]
            },
            {
                value: 'barracuda',
                label: 'Barracuda Networks',
                categories: ['firewall', 'loadbalancer'],
                models: [
                    { value: 'ngf_f400', label: 'CloudGen Firewall F400', type: 'firewall' },
                    { value: 'ngf_f600', label: 'CloudGen Firewall F600', type: 'firewall' },
                    { value: 'lb_540', label: 'Load Balancer 540', type: 'loadbalancer' }
                ]
            },
            {
                value: 'watchguard',
                label: 'WatchGuard',
                categories: ['firewall', 'wireless_ap'],
                models: [
                    { value: 'm470', label: 'Firebox M470', type: 'firewall' },
                    { value: 'm570', label: 'Firebox M570', type: 'firewall' },
                    { value: 'ap420', label: 'AP420', type: 'wireless_ap' }
                ]
            },
            {
                value: 'stormshield',
                label: 'Stormshield',
                categories: ['firewall'],
                models: [
                    { value: 'sn710', label: 'SN710', type: 'firewall' },
                    { value: 'sn910', label: 'SN910', type: 'firewall' },
                    { value: 'sn1100', label: 'SN1100', type: 'firewall' }
                ]
            },
            {
                value: 'quantum',
                label: 'Quantum',
                categories: ['storage_backup', 'storage_tape'],
                models: [
                    { value: 'dxi9000', label: 'DXi9000', type: 'storage_backup' },
                    { value: 'scalar_i6', label: 'Scalar i6', type: 'storage_tape' },
                    { value: 'scalar_i3', label: 'Scalar i3', type: 'storage_tape' }
                ]
            },
            {
                value: 'spectra',
                label: 'Spectra Logic',
                categories: ['storage_tape'],
                models: [
                    { value: 't950', label: 'T950 Library', type: 'storage_tape' },
                    { value: 't380', label: 'T380 Library', type: 'storage_tape' },
                    { value: 'stack', label: 'Stack Series', type: 'storage_tape' }
                ]
            },
            {
                value: 'tandberg',
                label: 'Tandberg Data',
                categories: ['storage_tape'],
                models: [
                    { value: 'neo_xl80', label: 'NEO XL-Series 80', type: 'storage_tape' },
                    { value: 'neo_s24', label: 'NEO S-Series 24', type: 'storage_tape' }
                ]
            },
            {
                value: 'infoblox',
                label: 'Infoblox',
                categories: ['server_physical'],
                models: [
                    { value: 'trinzic_815', label: 'Trinzic 815', type: 'server_physical' },
                    { value: 'trinzic_825', label: 'Trinzic 825', type: 'server_physical' }
                ]
            },
            {
                value: 'bluecoat',
                label: 'Blue Coat',
                categories: ['loadbalancer'],
                models: [
                    { value: 'av_2800', label: 'AV 2800', type: 'loadbalancer' },
                    { value: 'av_3800', label: 'AV 3800', type: 'loadbalancer' }
                ]
            },
            {
                value: 'f5',
                label: 'F5 Networks',
                categories: ['loadbalancer'],
                models: [
                    { value: 'big_ip_i4800', label: 'BIG-IP i4800', type: 'loadbalancer' },
                    { value: 'big_ip_i5800', label: 'BIG-IP i5800', type: 'loadbalancer' },
                    { value: 'big_ip_i7800', label: 'BIG-IP i7800', type: 'loadbalancer' }
                ]
            },
            {
                value: 'kemp',
                label: 'KEMP Technologies',
                categories: ['loadbalancer'],
                models: [
                    { value: 'lm_3400', label: 'LoadMaster 3400', type: 'loadbalancer' },
                    { value: 'lm_5400', label: 'LoadMaster 5400', type: 'loadbalancer' }
                ]
            },
            {
                value: 'radware',
                label: 'Radware',
                categories: ['loadbalancer'],
                models: [
                    { value: 'alteon_4408', label: 'Alteon 4408', type: 'loadbalancer' },
                    { value: 'alteon_4416', label: 'Alteon 4416', type: 'loadbalancer' }
                ]
            },
            {
                value: 'ibm',
                label: 'IBM',
                categories: ['server_physical', 'server_blade', 'storage_san'],
                models: [
                    { value: 'power_s1022', label: 'Power S1022', type: 'server_physical' },
                    { value: 'power_s1024', label: 'Power S1024', type: 'server_physical' },
                    { value: 'power_h922', label: 'Power H922', type: 'server_physical' },
                    { value: 'power_e1080', label: 'Power E1080', type: 'server_physical' },
                    { value: 'flashsystem_5200', label: 'FlashSystem 5200', type: 'storage_san' },
                    { value: 'flashsystem_7300', label: 'FlashSystem 7300', type: 'storage_san' }
                ]
            },
            {
                value: 'nutanix',
                label: 'Nutanix',
                categories: ['hypervisor_host', 'hypervisor_manager'],
                models: [
                    { value: 'nx_1065', label: 'NX-1065-G7', type: 'hypervisor_host' },
                    { value: 'nx_3060', label: 'NX-3060-G7', type: 'hypervisor_host' },
                    { value: 'nx_8035', label: 'NX-8035-G7', type: 'hypervisor_host' }
                ]
            },
            {
                value: 'vmware',
                label: 'VMware',
                categories: ['hypervisor_host', 'hypervisor_manager'],
                models: [
                    { value: 'vsphere_8', label: 'vSphere 8.0', type: 'hypervisor_host' },
                    { value: 'vcenter_8', label: 'vCenter Server 8.0', type: 'hypervisor_manager' },
                    { value: 'vsan_8', label: 'vSAN 8.0', type: 'hypervisor_host' }
                ]
            },
            {
                value: 'microsoft',
                label: 'Microsoft',
                categories: ['hypervisor_host', 'hypervisor_manager'],
                models: [
                    { value: 'hyperv_2022', label: 'Hyper-V 2022', type: 'hypervisor_host' },
                    { value: 'scvmm_2022', label: 'System Center VMM 2022', type: 'hypervisor_manager' }
                ]
            },
            {
                value: 'citrix',
                label: 'Citrix',
                categories: ['hypervisor_host', 'hypervisor_manager'],
                models: [
                    { value: 'xenserver_8_3', label: 'XenServer 8.3', type: 'hypervisor_host' },
                    { value: 'xenserver_8_2', label: 'XenServer 8.2', type: 'hypervisor_host' }
                ]
            },
            {
                value: 'proxmox',
                label: 'Proxmox',
                categories: ['hypervisor_host', 'hypervisor_manager'],
                models: [
                    { value: 'pve_8_0', label: 'Proxmox VE 8.0', type: 'hypervisor_host' },
                    { value: 'pve_7_4', label: 'Proxmox VE 7.4', type: 'hypervisor_host' }
                ]
            },
            {
                value: 'veeam',
                label: 'Veeam',
                categories: ['server_backup'],
                models: [
                    { value: 'backup_12', label: 'Backup & Replication 12', type: 'server_backup' },
                    { value: 'backup_11', label: 'Backup & Replication 11', type: 'server_backup' }
                ]
            },
            {
                value: 'veritas',
                label: 'Veritas',
                categories: ['server_backup', 'storage_backup'],
                models: [
                    { value: 'netbackup_10', label: 'NetBackup 10', type: 'server_backup' },
                    { value: 'netbackup_9_1', label: 'NetBackup 9.1', type: 'server_backup' },
                    { value: 'backup_exec_21', label: 'Backup Exec 21', type: 'storage_backup' }
                ]
            },
            {
                value: 'commvault',
                label: 'Commvault',
                categories: ['server_backup', 'storage_backup'],
                models: [
                    { value: 'complete_2023', label: 'Complete 2023', type: 'server_backup' },
                    { value: 'hyperscale_x', label: 'HyperScale X', type: 'storage_backup' }
                ]
            },
            {
                value: 'rubrik',
                label: 'Rubrik',
                categories: ['server_backup', 'storage_backup'],
                models: [
                    { value: 'r6410s', label: 'R6410S', type: 'storage_backup' },
                    { value: 'r6412s', label: 'R6412S', type: 'storage_backup' }
                ]
            },
            {
                value: 'cohesity',
                label: 'Cohesity',
                categories: ['server_backup', 'storage_backup'],
                models: [
                    { value: 'dataprotect', label: 'DataProtect', type: 'server_backup' },
                    { value: 'helios', label: 'Helios', type: 'storage_backup' }
                ]
            },
            {
                value: 'nakivo',
                label: 'NAKIVO',
                categories: ['server_backup'],
                models: [
                    { value: 'backup_v10', label: 'Backup & Replication v10', type: 'server_backup' },
                    { value: 'backup_v9', label: 'Backup & Replication v9', type: 'server_backup' }
                ]
            },
            {
                value: 'acronis',
                label: 'Acronis',
                categories: ['server_backup'],
                models: [
                    { value: 'cyber_protect_15', label: 'Cyber Protect 15', type: 'server_backup' },
                    { value: 'cyber_backup_12_5', label: 'Cyber Backup 12.5', type: 'server_backup' }
                ]
            },
            {
                value: 'storagecraft',
                label: 'StorageCraft',
                categories: ['server_backup'],
                models: [
                    { value: 'shadowprotect_spx', label: 'ShadowProtect SPX', type: 'server_backup' },
                    { value: 'oneblox_5210', label: 'OneBlox 5210', type: 'storage_backup' }
                ]
            },
            {
                value: 'msi',
                label: 'MSI',
                categories: ['pc_desktop', 'pc_laptop', 'pc_workstation'],
                models: [
                    // Masaüstü
                    { value: 'meg_aegis', label: 'MEG Aegis Ti5', type: 'pc_desktop' },
                    { value: 'mpg_trident', label: 'MPG Trident AS', type: 'pc_desktop' },
                    { value: 'mag_infinite', label: 'MAG Infinite S3', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'ge76_raider', label: 'GE76 Raider', type: 'pc_laptop' },
                    { value: 'gs66_stealth', label: 'GS66 Stealth', type: 'pc_laptop' },
                    { value: 'creator_z16', label: 'Creator Z16', type: 'pc_laptop' },
                    // İş İstasyonu
                    { value: 'ws65', label: 'WS65 Mobile Workstation', type: 'pc_workstation' }
                ]
            },
            {
                value: 'asus',
                label: 'ASUS',
                categories: ['pc_desktop', 'pc_laptop', 'pc_workstation'],
                models: [
                    // Masaüstü
                    { value: 'rog_gt35', label: 'ROG Strix GT35', type: 'pc_desktop' },
                    { value: 'rog_ga35', label: 'ROG Strix GA35', type: 'pc_desktop' },
                    { value: 'proart_pa90', label: 'ProArt Station PA90', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'rog_zephyrus', label: 'ROG Zephyrus G14', type: 'pc_laptop' },
                    { value: 'rog_strix_scar', label: 'ROG Strix Scar 17', type: 'pc_laptop' },
                    { value: 'zenbook_pro', label: 'ZenBook Pro Duo', type: 'pc_laptop' },
                    // İş İstasyonu
                    { value: 'proart_w730', label: 'ProArt StudioBook W730', type: 'pc_workstation' }
                ]
            },
            {
                value: 'acer',
                label: 'Acer',
                categories: ['pc_desktop', 'pc_laptop'],
                models: [
                    // Masaüstü
                    { value: 'predator_orion', label: 'Predator Orion 7000', type: 'pc_desktop' },
                    { value: 'nitro_50', label: 'Nitro 50', type: 'pc_desktop' },
                    { value: 'aspire_tc', label: 'Aspire TC Series', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'predator_triton', label: 'Predator Triton 500', type: 'pc_laptop' },
                    { value: 'swift_x', label: 'Swift X', type: 'pc_laptop' },
                    { value: 'travelmate_p6', label: 'TravelMate P6', type: 'pc_laptop' }
                ]
            },
            {
                value: 'razer',
                label: 'Razer',
                categories: ['pc_desktop', 'pc_laptop'],
                models: [
                    // Masaüstü
                    { value: 'tomahawk', label: 'Tomahawk Gaming Desktop', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'blade_15', label: 'Blade 15 Advanced', type: 'pc_laptop' },
                    { value: 'blade_14', label: 'Blade 14', type: 'pc_laptop' },
                    { value: 'blade_17', label: 'Blade 17 Pro', type: 'pc_laptop' }
                ]
            },
            {
                value: 'gigabyte',
                label: 'GIGABYTE',
                categories: ['pc_desktop', 'pc_laptop', 'pc_workstation'],
                models: [
                    // Masaüstü
                    { value: 'aorus_model_x', label: 'AORUS MODEL X', type: 'pc_desktop' },
                    { value: 'gb_gaming', label: 'GB Gaming PC', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'aorus_17', label: 'AORUS 17X', type: 'pc_laptop' },
                    { value: 'aero_15', label: 'AERO 15 OLED', type: 'pc_laptop' },
                    // İş İstasyonu
                    { value: 'aero_15_mobile', label: 'AERO 15 Mobile Workstation', type: 'pc_workstation' }
                ]
            },
            {
                value: 'alienware',
                label: 'Alienware',
                categories: ['pc_desktop', 'pc_laptop'],
                models: [
                    // Masaüstü
                    { value: 'aurora_r13', label: 'Aurora R13', type: 'pc_desktop' },
                    { value: 'aurora_r14', label: 'Aurora R14', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'x17_r2', label: 'X17 R2', type: 'pc_laptop' },
                    { value: 'm17_r5', label: 'M17 R5', type: 'pc_laptop' }
                ]
            },
            {
                value: 'microsoft',
                label: 'Microsoft',
                categories: ['pc_laptop'],
                models: [
                    { value: 'surface_laptop5', label: 'Surface Laptop 5', type: 'pc_laptop' },
                    { value: 'surface_laptop_studio', label: 'Surface Laptop Studio', type: 'pc_laptop' },
                    { value: 'surface_pro9', label: 'Surface Pro 9', type: 'pc_laptop' }
                ]
            },
            {
                value: 'huawei',
                label: 'Huawei',
                categories: ['pc_laptop'],
                models: [
                    { value: 'matebook_x_pro', label: 'MateBook X Pro', type: 'pc_laptop' },
                    { value: 'matebook_16s', label: 'MateBook 16s', type: 'pc_laptop' },
                    { value: 'matebook_d16', label: 'MateBook D16', type: 'pc_laptop' }
                ]
            },
            {
                value: 'samsung',
                label: 'Samsung',
                categories: ['pc_laptop'],
                models: [
                    { value: 'galaxy_book3_ultra', label: 'Galaxy Book3 Ultra', type: 'pc_laptop' },
                    { value: 'galaxy_book3_pro', label: 'Galaxy Book3 Pro', type: 'pc_laptop' },
                    { value: 'galaxy_book3_360', label: 'Galaxy Book3 360', type: 'pc_laptop' }
                ]
            },
            {
                value: 'lg',
                label: 'LG',
                categories: ['pc_laptop'],
                models: [
                    { value: 'gram_17', label: 'gram 17', type: 'pc_laptop' },
                    { value: 'gram_16', label: 'gram 16', type: 'pc_laptop' },
                    { value: 'gram_14', label: 'gram 14', type: 'pc_laptop' }
                ]
            },
            {
                value: 'vaio',
                label: 'VAIO',
                categories: ['pc_laptop'],
                models: [
                    { value: 'sx14', label: 'SX14', type: 'pc_laptop' },
                    { value: 'z', label: 'Z', type: 'pc_laptop' },
                    { value: 'fe14', label: 'FE14', type: 'pc_laptop' }
                ]
            },
            {
                value: 'monster',
                label: 'Monster',
                categories: ['pc_laptop', 'pc_desktop', 'pc_workstation'],
                models: [
                    // Dizüstü
                    { value: 'abra_a5', label: 'Abra A5 V17.2', type: 'pc_laptop' },
                    { value: 'abra_a7', label: 'Abra A7 V13.4', type: 'pc_laptop' },
                    { value: 'tulpar_t5', label: 'Tulpar T5 V20.3', type: 'pc_laptop' },
                    { value: 'tulpar_t7', label: 'Tulpar T7 V20.5', type: 'pc_laptop' },
                    { value: 'semruk_s7', label: 'Semruk S7 V13.1', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'markut_m2', label: 'Markut M2 V5.1', type: 'pc_desktop' },
                    { value: 'pusat_p2', label: 'Pusat P2 V3.2', type: 'pc_desktop' },
                    // İş İstasyonu
                    { value: 'huma_h5', label: 'Huma H5 V4.1', type: 'pc_workstation' }
                ]
            },
            {
                value: 'casper',
                label: 'Casper',
                categories: ['pc_laptop', 'pc_desktop'],
                models: [
                    // Dizüstü
                    { value: 'nirvana_x500', label: 'Nirvana X500', type: 'pc_laptop' },
                    { value: 'excalibur_g900', label: 'Excalibur G900', type: 'pc_laptop' },
                    { value: 'excalibur_g770', label: 'Excalibur G770', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'nirvana_n600', label: 'Nirvana N600', type: 'pc_desktop' },
                    { value: 'excalibur_e600', label: 'Excalibur E600', type: 'pc_desktop' }
                ]
            },
            {
                value: 'toshiba',
                label: 'Toshiba',
                categories: ['pc_laptop'],
                models: [
                    { value: 'portege_x40', label: 'Portégé X40-K', type: 'pc_laptop' },
                    { value: 'portege_x30', label: 'Portégé X30-K', type: 'pc_laptop' },
                    { value: 'tecra_a40', label: 'Tecra A40-K', type: 'pc_laptop' },
                    { value: 'tecra_a30', label: 'Tecra A30-K', type: 'pc_laptop' }
                ]
            },
            {
                value: 'fujitsu_client',
                label: 'Fujitsu Client Computing',
                categories: ['pc_laptop', 'pc_desktop', 'pc_workstation'],
                models: [
                    // Dizüstü
                    { value: 'lifebook_u9311', label: 'LIFEBOOK U9311', type: 'pc_laptop' },
                    { value: 'lifebook_e5511', label: 'LIFEBOOK E5511', type: 'pc_laptop' },
                    // Masaüstü
                    { value: 'esprimo_p958', label: 'ESPRIMO P958', type: 'pc_desktop' },
                    { value: 'esprimo_d538', label: 'ESPRIMO D538', type: 'pc_desktop' }
                ]
            },
            {
                value: 'panasonic',
                label: 'Panasonic',
                categories: ['pc_laptop'],
                models: [
                    { value: 'toughbook_55', label: 'Toughbook 55 mk2', type: 'pc_laptop' },
                    { value: 'toughbook_40', label: 'Toughbook 40', type: 'pc_laptop' },
                    { value: 'toughbook_g2', label: 'Toughbook G2', type: 'pc_laptop' }
                ]
            },
            {
                value: 'getac',
                label: 'Getac',
                categories: ['pc_laptop'],
                models: [
                    { value: 'b300', label: 'B300 G7', type: 'pc_laptop' },
                    { value: 'x500', label: 'X500 G3', type: 'pc_laptop' },
                    { value: 'v110', label: 'V110 G6', type: 'pc_laptop' }
                ]
            },
            {
                value: 'hyperbook',
                label: 'Hyperbook',
                categories: ['pc_laptop', 'pc_desktop'],
                models: [
                    { value: 'pulsar_z15', label: 'Pulsar Z15', type: 'pc_laptop' },
                    { value: 'pulsar_z17', label: 'Pulsar Z17', type: 'pc_laptop' },
                    { value: 'titan_g7', label: 'Titan G7', type: 'pc_desktop' }
                ]
            },
            {
                value: 'xmg',
                label: 'XMG',
                categories: ['pc_laptop'],
                models: [
                    { value: 'neo_15', label: 'NEO 15 E22', type: 'pc_laptop' },
                    { value: 'pro_17', label: 'PRO 17 E22', type: 'pc_laptop' },
                    { value: 'apex_15', label: 'APEX 15 Max', type: 'pc_laptop' }
                ]
            },
            {
                value: 'eurocom',
                label: 'Eurocom',
                categories: ['pc_laptop', 'pc_workstation'],
                models: [
                    { value: 'sky_z7', label: 'Sky Z7 Pro', type: 'pc_laptop' },
                    { value: 'nightsky_rx15', label: 'Nightsky RX15', type: 'pc_laptop' },
                    { value: 'mobile_workstation', label: 'Mobile Workstation', type: 'pc_workstation' }
                ]
            },
            {
                value: 'system76',
                label: 'System76',
                categories: ['pc_laptop', 'pc_desktop'],
                models: [
                    { value: 'oryx_pro', label: 'Oryx Pro', type: 'pc_laptop' },
                    { value: 'darter_pro', label: 'Darter Pro', type: 'pc_laptop' },
                    { value: 'thelio', label: 'Thelio', type: 'pc_desktop' }
                ]
            },
            {
                value: 'gamegaraj',
                label: 'GameGaraj',
                categories: ['pc_desktop', 'pc_laptop'],
                models: [
                    // Masaüstü
                    { value: 'guardian_5', label: 'Guardian 5 Gaming', type: 'pc_desktop' },
                    { value: 'guardian_7', label: 'Guardian 7 Gaming', type: 'pc_desktop' },
                    { value: 'paladin_5', label: 'Paladin 5 Gaming', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'legion_5', label: 'Legion 5 Gaming', type: 'pc_laptop' },
                    { value: 'legion_7', label: 'Legion 7 Gaming', type: 'pc_laptop' }
                ]
            },
            {
                value: 'rampage',
                label: 'Rampage',
                categories: ['pc_desktop'],
                models: [
                    { value: 'phantom_x', label: 'PHANTOM-X Gaming', type: 'pc_desktop' },
                    { value: 'shadow_x', label: 'SHADOW-X Gaming', type: 'pc_desktop' },
                    { value: 'thunder_x', label: 'THUNDER-X Gaming', type: 'pc_desktop' }
                ]
            },
            {
                value: 'exper',
                label: 'Exper',
                categories: ['pc_desktop', 'pc_laptop'],
                models: [
                    // Masaüstü
                    { value: 'flex_dex', label: 'Flex DEX', type: 'pc_desktop' },
                    { value: 'flex_vex', label: 'Flex VEX', type: 'pc_desktop' },
                    // Dizüstü
                    { value: 'swift_x', label: 'Swift X', type: 'pc_laptop' },
                    { value: 'swift_pro', label: 'Swift Pro', type: 'pc_laptop' }
                ]
            },
            {
                value: 'hometech',
                label: 'Hometech',
                categories: ['pc_laptop'],
                models: [
                    { value: 'alfa_600', label: 'Alfa 600', type: 'pc_laptop' },
                    { value: 'alfa_700', label: 'Alfa 700', type: 'pc_laptop' },
                    { value: 'alfa_900', label: 'Alfa 900', type: 'pc_laptop' }
                ]
            },
            {
                value: 'pcart',
                label: 'PCart',
                categories: ['pc_desktop'],
                models: [
                    { value: 'gaming_pro', label: 'Gaming Pro', type: 'pc_desktop' },
                    { value: 'gaming_elite', label: 'Gaming Elite', type: 'pc_desktop' },
                    { value: 'gaming_ultra', label: 'Gaming Ultra', type: 'pc_desktop' }
                ]
            },
            {
                value: 'dragos',
                label: 'Dragos',
                categories: ['pc_desktop'],
                models: [
                    { value: 'dg100', label: 'DG100 Gaming', type: 'pc_desktop' },
                    { value: 'dg200', label: 'DG200 Gaming', type: 'pc_desktop' },
                    { value: 'dg300', label: 'DG300 Gaming', type: 'pc_desktop' }
                ]
            },
            {
                value: 'technopc',
                label: 'TechnoPc',
                categories: ['pc_desktop'],
                models: [
                    { value: 'gaming_x15', label: 'Gaming X15', type: 'pc_desktop' },
                    { value: 'gaming_x20', label: 'Gaming X20', type: 'pc_desktop' },
                    { value: 'gaming_x25', label: 'Gaming X25', type: 'pc_desktop' }
                ]
            },
            {
                value: 'performax',
                label: 'Performax',
                categories: ['pc_desktop'],
                models: [
                    { value: 'prx_100', label: 'PRX-100 Gaming', type: 'pc_desktop' },
                    { value: 'prx_200', label: 'PRX-200 Gaming', type: 'pc_desktop' },
                    { value: 'prx_300', label: 'PRX-300 Gaming', type: 'pc_desktop' }
                ]
            },
            {
                value: 'i_ray',
                label: 'i-Ray',
                categories: ['pc_desktop'],
                models: [
                    { value: 'gaming_starter', label: 'Gaming Starter', type: 'pc_desktop' },
                    { value: 'gaming_pro', label: 'Gaming Pro', type: 'pc_desktop' },
                    { value: 'gaming_elite', label: 'Gaming Elite', type: 'pc_desktop' }
                ]
            },
            {
                value: 'turbox',
                label: 'Turbox',
                categories: ['pc_desktop'],
                models: [
                    { value: 'tx100', label: 'TX100 Gaming', type: 'pc_desktop' },
                    { value: 'tx200', label: 'TX200 Gaming', type: 'pc_desktop' },
                    { value: 'tx300', label: 'TX300 Gaming', type: 'pc_desktop' }
                ]
            },
            {
                value: 'inspur',
                label: 'Inspur',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'nf5180m6', label: 'NF5180M6', type: 'server_physical' },
                    { value: 'nf5280m6', label: 'NF5280M6', type: 'server_physical' },
                    { value: 'nf8480m6', label: 'NF8480M6', type: 'server_physical' },
                    { value: 'nf5888m6', label: 'NF5888M6', type: 'server_physical' },
                    { value: 'sm224b', label: 'SM224B Blade', type: 'server_blade' }
                ]
            },
            {
                value: 'huawei_server',
                label: 'Huawei Server',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: '2288h_v6', label: '2288H V6', type: 'server_physical' },
                    { value: '2298_v6', label: '2298 V6', type: 'server_physical' },
                    { value: '1288h_v6', label: '1288H V6', type: 'server_physical' },
                    { value: 'ch121_v6', label: 'CH121 V6 Blade', type: 'server_blade' },
                    { value: 'ch242_v6', label: 'CH242 V6 Blade', type: 'server_blade' }
                ]
            },
            {
                value: 'oracle_server',
                label: 'Oracle Server',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'x9_2', label: 'X9-2 Server', type: 'server_physical' },
                    { value: 'x9_2l', label: 'X9-2L Server', type: 'server_physical' },
                    { value: 'x9_4', label: 'X9-4 Server', type: 'server_physical' },
                    { value: 'x9_8', label: 'X9-8 Server', type: 'server_physical' }
                ]
            },
            {
                value: 'atos',
                label: 'Atos',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'bx2590_m2', label: 'BullSequana X2590 M2', type: 'server_physical' },
                    { value: 'bx2560_m2', label: 'BullSequana X2560 M2', type: 'server_physical' },
                    { value: 'bx2540_m2', label: 'BullSequana X2540 M2', type: 'server_physical' }
                ]
            },
            {
                value: 'nec',
                label: 'NEC',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'r120h_m6', label: 'Express5800 R120h-M6', type: 'server_physical' },
                    { value: 'r110k_m6', label: 'Express5800 R110k-M6', type: 'server_physical' },
                    { value: 'b120h_m6', label: 'Express5800 B120h-M6', type: 'server_blade' }
                ]
            },
            {
                value: 'sugon',
                label: 'Sugon',
                categories: ['server_physical', 'server_blade'],
                models: [
                    { value: 'i620', label: 'I620-G40', type: 'server_physical' },
                    { value: 'i640', label: 'I640-G40', type: 'server_physical' },
                    { value: 'i840', label: 'I840-G40', type: 'server_physical' }
                ]
            },
            {
                value: 'proxmox_ve',
                label: 'Proxmox VE',
                categories: ['server_virtual'],
                models: [
                    { value: 'pve_container', label: 'LXC Container', type: 'server_virtual' },
                    { value: 'pve_qemu', label: 'QEMU VM', type: 'server_virtual' }
                ]
            },
            {
                value: 'vmware_virtual',
                label: 'VMware Virtual',
                categories: ['server_virtual'],
                models: [
                    { value: 'vsphere_vm', label: 'vSphere VM', type: 'server_virtual' },
                    { value: 'vsphere_template', label: 'vSphere Template', type: 'server_virtual' },
                    { value: 'vsphere_appliance', label: 'vSphere Appliance', type: 'server_virtual' }
                ]
            },
            {
                value: 'hyper_v',
                label: 'Hyper-V',
                categories: ['server_virtual'],
                models: [
                    { value: 'gen1_vm', label: 'Generation 1 VM', type: 'server_virtual' },
                    { value: 'gen2_vm', label: 'Generation 2 VM', type: 'server_virtual' }
                ]
            },
            {
                value: 'kvm_virtual',
                label: 'KVM Virtual',
                categories: ['server_virtual'],
                models: [
                    { value: 'kvm_linux', label: 'KVM Linux VM', type: 'server_virtual' },
                    { value: 'kvm_windows', label: 'KVM Windows VM', type: 'server_virtual' }
                ]
            },
            {
                value: 'xen_virtual',
                label: 'Xen Virtual',
                categories: ['server_virtual'],
                models: [
                    { value: 'xen_pv', label: 'Xen PV Guest', type: 'server_virtual' },
                    { value: 'xen_hvm', label: 'Xen HVM Guest', type: 'server_virtual' }
                ]
            },
            {
                value: 'oracle_virtual',
                label: 'Oracle Virtual',
                categories: ['server_virtual'],
                models: [
                    { value: 'virtualbox_vm', label: 'VirtualBox VM', type: 'server_virtual' },
                    { value: 'oci_vm', label: 'Oracle Cloud VM', type: 'server_virtual' }
                ]
            },
            {
                value: 'parallels',
                label: 'Parallels',
                categories: ['server_virtual'],
                models: [
                    { value: 'parallels_vm', label: 'Parallels VM', type: 'server_virtual' },
                    { value: 'parallels_ct', label: 'Parallels Container', type: 'server_virtual' }
                ]
            },
            {
                value: 'other',
                label: 'Diğer',
                categories: ['pc_desktop', 'pc_laptop', 'pc_workstation', 'server_physical', 'server_blade', 'server_virtual', 'switch_l2', 'switch_l3', 'router', 'firewall', 'wireless_ap', 'wireless_controller', 'storage_nas', 'storage_san', 'storage_backup', 'storage_tape', 'ups', 'pdu', 'kvm', 'printer_laser', 'printer_inkjet', 'printer_multi', 'scanner', 'camera_ip', 'camera_nvr', 'sensor_temp', 'sensor_humidity', 'sensor_motion', 'access_control', 'loadbalancer'],
                models: [
                    // Bilgisayarlar
                    { value: 'other_desktop', label: 'Diğer Masaüstü', type: 'pc_desktop' },
                    { value: 'other_laptop', label: 'Diğer Dizüstü', type: 'pc_laptop' },
                    { value: 'other_workstation', label: 'Diğer İş İstasyonu', type: 'pc_workstation' },
                    // Sunucular
                    { value: 'other_server', label: 'Diğer Fiziksel Sunucu', type: 'server_physical' },
                    { value: 'other_blade', label: 'Diğer Blade Sunucu', type: 'server_blade' },
                    { value: 'other_virtual', label: 'Diğer Sanal Sunucu', type: 'server_virtual' },
                    // Ağ Cihazları
                    { value: 'other_switch_l2', label: 'Diğer L2 Switch', type: 'switch_l2' },
                    { value: 'other_switch_l3', label: 'Diğer L3 Switch', type: 'switch_l3' },
                    { value: 'other_router', label: 'Diğer Router', type: 'router' },
                    { value: 'other_firewall', label: 'Diğer Firewall', type: 'firewall' },
                    { value: 'other_ap', label: 'Diğer Access Point', type: 'wireless_ap' },
                    { value: 'other_wlc', label: 'Diğer Wireless Controller', type: 'wireless_controller' },
                    // Depolama
                    { value: 'other_nas', label: 'Diğer NAS', type: 'storage_nas' },
                    { value: 'other_san', label: 'Diğer SAN', type: 'storage_san' },
                    { value: 'other_backup', label: 'Diğer Yedekleme Ünitesi', type: 'storage_backup' },
                    { value: 'other_tape', label: 'Diğer Teyp Ünitesi', type: 'storage_tape' },
                    // Güç ve KVM
                    { value: 'other_ups', label: 'Diğer UPS', type: 'ups' },
                    { value: 'other_pdu', label: 'Diğer PDU', type: 'pdu' },
                    { value: 'other_kvm', label: 'Diğer KVM', type: 'kvm' },
                    // Yazıcı ve Tarayıcılar
                    { value: 'other_laser', label: 'Diğer Lazer Yazıcı', type: 'printer_laser' },
                    { value: 'other_inkjet', label: 'Diğer Mürekkep Yazıcı', type: 'printer_inkjet' },
                    { value: 'other_mfp', label: 'Diğer Çok Fonksiyonlu Yazıcı', type: 'printer_multi' },
                    { value: 'other_scanner', label: 'Diğer Tarayıcı', type: 'scanner' },
                    // Güvenlik
                    { value: 'other_ipcam', label: 'Diğer IP Kamera', type: 'camera_ip' },
                    { value: 'other_nvr', label: 'Diğer NVR', type: 'camera_nvr' },
                    // Sensörler
                    { value: 'other_temp', label: 'Diğer Sıcaklık Sensörü', type: 'sensor_temp' },
                    { value: 'other_humidity', label: 'Diğer Nem Sensörü', type: 'sensor_humidity' },
                    { value: 'other_motion', label: 'Diğer Hareket Sensörü', type: 'sensor_motion' },
                    // Diğer
                    { value: 'other_access', label: 'Diğer Geçiş Kontrol', type: 'access_control' },
                    { value: 'other_lb', label: 'Diğer Load Balancer', type: 'loadbalancer' }
                ]
            },
            {
                value: 'unspecified',
                label: 'Belirtilmemiş',
                categories: ['pc_desktop', 'pc_laptop', 'pc_workstation', 'server_physical', 'server_blade', 'server_virtual', 'switch_l2', 'switch_l3', 'router', 'firewall', 'wireless_ap', 'wireless_controller', 'storage_nas', 'storage_san', 'storage_backup', 'storage_tape', 'ups', 'pdu', 'kvm', 'printer_laser', 'printer_inkjet', 'printer_multi', 'scanner', 'camera_ip', 'camera_nvr', 'sensor_temp', 'sensor_humidity', 'sensor_motion', 'access_control', 'loadbalancer'],
                models: [
                    // Bilgisayarlar
                    { value: 'unspecified_desktop', label: 'Masaüstü - Model Belirtilmemiş', type: 'pc_desktop' },
                    { value: 'unspecified_laptop', label: 'Dizüstü - Model Belirtilmemiş', type: 'pc_laptop' },
                    { value: 'unspecified_workstation', label: 'İş İstasyonu - Model Belirtilmemiş', type: 'pc_workstation' },
                    // Sunucular
                    { value: 'unspecified_server', label: 'Fiziksel Sunucu - Model Belirtilmemiş', type: 'server_physical' },
                    { value: 'unspecified_blade', label: 'Blade Sunucu - Model Belirtilmemiş', type: 'server_blade' },
                    { value: 'unspecified_virtual', label: 'Sanal Sunucu - Model Belirtilmemiş', type: 'server_virtual' },
                    // Ağ Cihazları
                    { value: 'unspecified_switch_l2', label: 'L2 Switch - Model Belirtilmemiş', type: 'switch_l2' },
                    { value: 'unspecified_switch_l3', label: 'L3 Switch - Model Belirtilmemiş', type: 'switch_l3' },
                    { value: 'unspecified_router', label: 'Router - Model Belirtilmemiş', type: 'router' },
                    { value: 'unspecified_firewall', label: 'Firewall - Model Belirtilmemiş', type: 'firewall' },
                    { value: 'unspecified_ap', label: 'Access Point - Model Belirtilmemiş', type: 'wireless_ap' },
                    { value: 'unspecified_wlc', label: 'Wireless Controller - Model Belirtilmemiş', type: 'wireless_controller' },
                    // Depolama
                    { value: 'unspecified_nas', label: 'NAS - Model Belirtilmemiş', type: 'storage_nas' },
                    { value: 'unspecified_san', label: 'SAN - Model Belirtilmemiş', type: 'storage_san' },
                    { value: 'unspecified_backup', label: 'Yedekleme Ünitesi - Model Belirtilmemiş', type: 'storage_backup' },
                    { value: 'unspecified_tape', label: 'Teyp Ünitesi - Model Belirtilmemiş', type: 'storage_tape' },
                    // Güç ve KVM
                    { value: 'unspecified_ups', label: 'UPS - Model Belirtilmemiş', type: 'ups' },
                    { value: 'unspecified_pdu', label: 'PDU - Model Belirtilmemiş', type: 'pdu' },
                    { value: 'unspecified_kvm', label: 'KVM - Model Belirtilmemiş', type: 'kvm' },
                    // Yazıcı ve Tarayıcılar
                    { value: 'unspecified_laser', label: 'Lazer Yazıcı - Model Belirtilmemiş', type: 'printer_laser' },
                    { value: 'unspecified_inkjet', label: 'Mürekkep Yazıcı - Model Belirtilmemiş', type: 'printer_inkjet' },
                    { value: 'unspecified_mfp', label: 'Çok Fonksiyonlu Yazıcı - Model Belirtilmemiş', type: 'printer_multi' },
                    { value: 'unspecified_scanner', label: 'Tarayıcı - Model Belirtilmemiş', type: 'scanner' },
                    // Güvenlik
                    { value: 'unspecified_ipcam', label: 'IP Kamera - Model Belirtilmemiş', type: 'camera_ip' },
                    { value: 'unspecified_nvr', label: 'NVR - Model Belirtilmemiş', type: 'camera_nvr' },
                    // Sensörler
                    { value: 'unspecified_temp', label: 'Sıcaklık Sensörü - Model Belirtilmemiş', type: 'sensor_temp' },
                    { value: 'unspecified_humidity', label: 'Nem Sensörü - Model Belirtilmemiş', type: 'sensor_humidity' },
                    { value: 'unspecified_motion', label: 'Hareket Sensörü - Model Belirtilmemiş', type: 'sensor_motion' },
                    // Diğer
                    { value: 'unspecified_access', label: 'Geçiş Kontrol - Model Belirtilmemiş', type: 'access_control' },
                    { value: 'unspecified_lb', label: 'Load Balancer - Model Belirtilmemiş', type: 'loadbalancer' }
                ]
            }
        ];

        // Mevcut settings nesnesini güncelle (başlangıçta)
        let settings = {
            refreshInterval: 150,
            pingTimeout: 1000,
            viewMode: 'compact',
            groupView: true,
            sound: {
                enabled: true,
                volume: 1,
                rate: 1,
                pitch: 1,
                language: 'tr-TR'
            }
        };

        // settings nesnesini tekrar tanımlamak yerine güncelle
        function loadSettings() {
            const savedSettings = localStorage.getItem('settings');
            if (savedSettings) {
                const parsed = JSON.parse(savedSettings);
                settings = {
                    ...settings,
                    ...parsed,
                    sound: {
                        ...settings.sound,
                        ...parsed.sound
                    }
                };
            }
        }

        // Ayarları yükle
        function updateSettingsForm() {
            const form = document.getElementById('settingsForm');
            if (!form) return;

            // Form elemanlarını mevcut ayarlarla doldur
            form.elements.refreshInterval.value = settings.refreshInterval;
            form.elements.pingTimeout.value = settings.pingTimeout;
            form.elements.viewMode.value = settings.viewMode;
            
            // Gruplama ayarını kontrol et ve ayarla
            if (form.elements.groupView) {
                form.elements.groupView.checked = settings.groupView === true;
            }
        }

        // Ayarlar modalını aç
        function openSettingsModal() {
            document.getElementById('settingsModal').style.display = 'block';
            updateSettingsForm();
            loadSoundSettings();
        }

        // Ayarlar modalını kapat
        function closeSettingsModal() {
            document.getElementById('settingsModal').style.display = 'none';
        }

        // Ayarları kaydet
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveSoundSettings();
            
            // Mevcut ayarları koru ve yeni değerleri ekle
            settings = {
                ...settings, // Mevcut ayarları koru
                refreshInterval: parseInt(this.elements.refreshInterval.value),
                pingTimeout: parseInt(this.elements.pingTimeout.value),
                viewMode: this.elements.viewMode.value,
                groupView: this.elements.groupView.checked,
                sound: {
                    ...settings.sound // Ses ayarlarını koru
                }
            };
            
            localStorage.setItem('settings', JSON.stringify(settings));
            
            // Yenileme aralığını güncelle
            clearInterval(checkInterval);
            checkInterval = setInterval(checkDevices, settings.refreshInterval * 1000);
            
            closeSettingsModal();
            updateDevices(); // Görünümü güncelle
            alert('Ayarlar kaydedildi!');
        });

        // Interval değişkeni
        let checkInterval;

        // Modal fonksiyonları
        function openModal() {
            document.getElementById('addDeviceModal').style.display = 'block';
            
            // Yeni cihaz ekleme durumunda boş form göster
            if (!document.getElementById('addForm').dataset.editMode) {
                updateDeviceForm();
            }
        }

        function closeModal() {
            document.getElementById('addDeviceModal').style.display = 'none';
            document.getElementById('addForm').reset();
        }

        // Modal dışına tıklandığında kapatma
        window.onclick = function(event) {
            const modal = document.getElementById('addDeviceModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // ESC tuşu ile modalı kapatma
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Cihaz kontrolü fonksiyonunu güncelleyelim
        async function checkDevices() {
            for (let device of devices) {
                try {
                    const response = await fetch('ping.php?ip=' + device.ip);
                    const data = await response.json();
                    
                    // Önceki durumu sakla
                    const prevStatus = device.status;
                    const prevEndStatus = device.endStatus || prevStatus; // İlk kez için
                    
                    // Yeni durumu güncelle
                    device.status = data.status;
                    device.latency = data.latency;
                    device.last_check = new Date().toLocaleTimeString('tr-TR');
                    
                    // End-status kontrolü
                    if (device.status !== prevEndStatus) {
                        // Durum değişikliğini seslendir
                        const message = `${device.name} ${device.status ? 'çevrimiçi' : 'çevrimdışı'} oldu`;
                        speakNotification(message);
                        
                        // End-status'u güncelle
                        device.endStatus = device.status;
                    }
                } catch (error) {
                    const prevStatus = device.status;
                    const prevEndStatus = device.endStatus || prevStatus;
                    
                    device.status = false;
                    device.latency = null;
                    device.last_check = new Date().toLocaleTimeString('tr-TR');
                    
                    // Hata durumunda end-status kontrolü
                    if (false !== prevEndStatus) {
                        speakNotification(`${device.name} çevrimdışı oldu`);
                        device.endStatus = false;
                    }
                }
            }
            
            localStorage.setItem('devices', JSON.stringify(devices));
            updateDevices();
            updateLastCheck();
        }

        // Text to Speech fonksiyonu
        function speakNotification(message) {
            // Tarayıcı desteğini kontrol et
            if ('speechSynthesis' in window) {
                // Seslendirme için yeni bir nesne oluştur
                const utterance = new SpeechSynthesisUtterance(message);
                
                // Türkçe dil desteği
                utterance.lang = 'tr-TR';
                
                // Ses ayarları
                utterance.volume = 1; // 0 ile 1 arası
                utterance.rate = 1; // 0.1 ile 10 arası
                utterance.pitch = 1; // 0 ile 2 arası
                
                // Seslendirmeyi başlat
                window.speechSynthesis.speak(utterance);
            }
        }

        function getPingClass(latency) {
            if (!latency) return '';
            if (latency <= 15) return 'ping-excellent';
            if (latency <= 35) return 'ping-good';
            if (latency <= 50) return 'ping-warning';
            return 'ping-critical';
        }

        function updateDevices() {
            const container = document.getElementById('deviceList');
            const currentView = settings.groupView;
            
            // Mevcut görünümü koru
            if (!currentView) {
                // Grid görünümü
                container.innerHTML = `
                    <div class="device-grid">
                        ${generateDeviceCards(devices)}
                    </div>
                `;
            } else {
                // Grup görünümü
                let html = '';
                
                // Grupsuz cihazlar
                const ungrouped = devices.filter(d => !d.group);
                if (ungrouped.length > 0) {
                    html += `
                        <div class="device-grid ungrouped-devices">
                            ${generateDeviceCards(ungrouped)}
                        </div>
                    `;
                }
                
                // Gruplu cihazlar
                const groupedDevices = {};
                devices.forEach(device => {
                    if (device.group) {
                        if (!groupedDevices[device.group]) {
                            groupedDevices[device.group] = [];
                        }
                        groupedDevices[device.group].push(device);
                    }
                });

                if (Object.keys(groupedDevices).length > 0) {
                    html += '<div class="groups-container">';
                    Object.entries(groupedDevices).forEach(([groupName, groupDevices]) => {
                        const group = groups.find(g => g.name === groupName);
                        if (group) {
                            html += `
                                <div class="device-group">
                                    <div class="group-header">
                                        <div class="group-info">
                                            <div class="group-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <div class="group-title">
                                                <h3>${group.name}</h3>
                                                <span class="group-stats">
                                                    ${groupDevices.length} Cihaz (${groupDevices.filter(d => d.status).length} Çevrimiçi)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="device-grid">
                                        ${generateDeviceCards(groupDevices)}
                                    </div>
                                </div>
                            `;
                        }
                    });
                    html += '</div>';
                }
                
                container.innerHTML = html;
            }

            // Cihaz sayılarını güncelle
            updateDeviceCounts();
        }

        // Cihaz sayılarını güncelleme fonksiyonu
        function updateDeviceCounts() {
            const totalDevices = devices.length;
            const onlineDevices = devices.filter(d => d.status).length;
            
            document.getElementById('totalDevices').textContent = totalDevices;
            document.getElementById('onlineDevices').textContent = onlineDevices;
            document.getElementById('offlineDevices').textContent = totalDevices - onlineDevices;
        }

        // Cihaz kartları oluştur
        function generateDeviceCards(deviceList) {
            return deviceList.map(device => {
                const pingClass = device.status ? getPingClass(device.latency) : 'offline';
                return `
                    <div class="device-card ${pingClass}">
                        <div class="card-actions">
                            <button class="edit-btn" onclick="editDevice('${device.ip}')" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn" onclick="deleteDevice('${device.ip}')" title="Sil">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="device-header">
                            <span class="status-badge">
                                <i class="fas ${device.status ? 'fa-check' : 'fa-times'}"></i>
                            </span>
                            <div class="device-name">${device.name}</div>
                        </div>
                        <div class="device-ip-row">
                            <span class="ip">${device.ip}</span>
                            <span class="ping">${device.latency ? device.latency + ' ms' : '-'}</span>
                        </div>
                        <div class="device-info">
                            <span>Son Kontrol:</span>
                            <span>${device.last_check || '-'}</span>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Düzenleme fonksiyonunu güncelleyelim
        function editDevice(ip) {
            const device = devices.find(d => d.ip === ip);
            if (!device) return;
            
            // Form alanlarını doldur
            const form = document.getElementById('addForm');
            
            // Modal başlığını güncelle
            document.querySelector('.modal-title').textContent = 'Cihaz Düzenle';
            document.querySelector('.submit-btn').textContent = 'Güncelle';
            
            // Form gönderildiğinde güncelleme yapılacak
            form.dataset.editMode = 'true';
            form.dataset.originalIp = ip;
            
            // Modalı aç
            openModal();
            
            // Form değerlerini doldur (Modal açıldıktan sonra)
            setTimeout(() => {
                // Temel bilgileri doldur
                form.elements.name.value = device.name || '';
                form.elements.ip.value = device.ip || '';
                
                // Önce cihaz tipini seç
                const typeSelect = form.elements.type;
                typeSelect.value = device.type || '';
                
                // Marka seçeneklerini güncelle ve seçili markayı ayarla
                updateBrandOptions(device.type);
                setTimeout(() => {
                    const brandSelect = form.elements.brand;
                    brandSelect.value = device.brand || '';
                    
                    // Model seçeneklerini güncelle ve seçili modeli ayarla
                    updateModelOptions(device.brand);
                    setTimeout(() => {
                        const modelSelect = form.elements.model;
                        modelSelect.value = device.model || '';
                    }, 100);
                }, 100);
                
                // İşletim sistemi ve versiyon seçeneklerini güncelle
                updateDeviceForm(device.group, device.type, device.os, device.osVersion);
                
                // İşletim sistemi ve versiyon değerlerini ayarla
                form.elements.os.value = device.os || '';
                if (device.os) {
                    updateOsVersions(device.os, device.osVersion);
                    form.elements.osVersion.value = device.osVersion || '';
                }
                
                // Grup seçimini ayarla
                if (form.elements.group) {
                    form.elements.group.value = device.group || '';
                }

                // Etki alanı bilgilerini doldur (setTimeout ile bekleyerek)
                setTimeout(() => {
                    if (form.elements.domain) {
                form.elements.domain.value = device.domain || '';
                    }
                    if (form.elements.domainComputerName) {
                form.elements.domainComputerName.value = device.domainComputerName || '';
                    }
                    if (form.elements.domainUsername) {
                form.elements.domainUsername.value = device.domainUsername || '';
                    }
                    if (form.elements.domainPassword) {
                form.elements.domainPassword.value = device.domainPassword || '';
                    }
                }, 200);

            }, 100);
        }

        // Form submit olayını da güncelleyelim
        document.getElementById('addForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = this.elements.name.value.trim();
            const ip = this.elements.ip.value.trim();
            const type = this.elements.type.value;
            const brand = this.elements.brand.value;
            const model = this.elements.model.value;
            const os = this.elements.os.value;
            const osVersion = this.elements.osVersion.value;
            const group = this.elements.group.value;
            
            const deviceData = {
                name: name,
                ip: ip,
                type: type,
                brand: brand,
                model: model,
                os: os,
                osVersion: osVersion,
                group: group || null,
                // Yeni alanları ekle
                domain: this.elements.domain.value.trim(),
                domainComputerName: this.elements.domainComputerName.value.trim(),
                domainUsername: this.elements.domainUsername.value.trim(),
                domainPassword: this.elements.domainPassword.value.trim(),
                status: false,
                endStatus: false, // Yeni eklenen alan
                latency: null,
                last_check: '-'
            };
            
            if (this.dataset.editMode === 'true') {
                const originalIp = this.dataset.originalIp;
                const deviceIndex = devices.findIndex(d => d.ip === originalIp);
                
                if (deviceIndex !== -1) {
                    devices[deviceIndex] = { ...devices[deviceIndex], ...deviceData };
                }
            } else {
                devices.push(deviceData);
            }
            
            localStorage.setItem('devices', JSON.stringify(devices));
            this.reset();
            this.dataset.editMode = 'false';
            delete this.dataset.originalIp;
            document.querySelector('.modal-title').textContent = 'Yeni Cihaz Ekle';
            document.querySelector('.submit-btn').textContent = 'Ekle';
            closeModal();
            
            updateDevices();
            checkDevices();
        });

        function deleteDevice(ip) {
            if (!confirm('Bu cihazı silmek isteadiğinizden emin misiniz?')) return;
            
            devices = devices.filter(device => device.ip !== ip);
            localStorage.setItem('devices', JSON.stringify(devices));
            updateDevices();
        }

        updateDevices();
        checkDevices();
        setInterval(checkDevices, 150000);

        // Tema yönetimi
        function setTheme(isDark) {
            document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('themeSwitch').checked = isDark;
        }

        // Sayfa yüklendiğinde
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme === 'dark');
        });

        // Switch değiştiğinde
        document.getElementById('themeSwitch').addEventListener('change', function(e) {
            setTheme(e.target.checked);
        });

        // Veri dışa aktarma fonksiyonu
        function exportDevices() {
            const exportData = {
                version: '1.0',
                exportDate: new Date().toISOString(),
                data: {
                    devices: devices,
                    groups: groups,
                    settings: settings
                }
            };

            const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `network_backup_${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }

        // Veri içe aktarma fonksiyonu
        function importDevices() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.json';
            input.onchange = function(e) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    try {
                        const importData = JSON.parse(event.target.result);
                        
                        // Versiyon kontrolü
                        if (!importData.version) {
                            throw new Error('Geçersiz dosya formatı');
                        }

                        // Veri doğrulama
                        if (!importData.data) {
                            throw new Error('Veri bulunamadı');
                        }

                        let message = 'İçe aktarılan:\n';
                        
                        // Cihazları içe aktar
                        if (importData.data.devices && Array.isArray(importData.data.devices)) {
                            devices = importData.data.devices;
                            localStorage.setItem('devices', JSON.stringify(devices));
                            message += `- ${devices.length} cihaz\n`;
                        }

                        // Grupları içe aktar
                        if (importData.data.groups && Array.isArray(importData.data.groups)) {
                            groups = importData.data.groups;
                            localStorage.setItem('groups', JSON.stringify(groups));
                            message += `- ${groups.length} grup\n`;
                        }

                        // Ayarları içe aktar
                        if (importData.data.settings) {
                            settings = {
                                ...settings,
                                ...importData.data.settings
                            };
                            localStorage.setItem('settings', JSON.stringify(settings));
                            message += '- Sistem ayarları\n';
                            
                            // Yenileme aralığını güncelle
                            clearInterval(checkInterval);
                            checkInterval = setInterval(checkDevices, settings.refreshInterval * 1000);
                        }

                        // Arayüzü güncelle
                        updateDevices();
                        updateSettingsForm();
                        loadSoundSettings();

                        alert(message + '\nVeriler başarıyla içe aktarıldı!');

                    } catch (error) {
                        alert('Hata: ' + (error.message || 'Dosya okunamadı veya geçersiz format!'));
                    }
                };
                reader.readAsText(file);
            };
            input.click();
        }

        // Son kontrol zamanı için yeni bir fonksiyon ekleyelim
        function updateLastCheck() {
            const now = new Date();
            const time = now.toLocaleTimeString('tr-TR');
            document.getElementById('lastCheck').textContent = time;
        }

        // Sayfa yüklendiğinde
        document.addEventListener('DOMContentLoaded', () => {
            loadSettings();
            // Mevcut interval'i temizle ve yeni ayarlarla başlat
            clearInterval(checkInterval);
            checkInterval = setInterval(checkDevices, settings.refreshInterval * 1000);
        });

        // Cihaz formuna grup seçeneği ekleyelim
        function updateDeviceForm(selectedGroup = '', selectedType = '', selectedOs = '', selectedOsVersion = '') {
            const form = document.getElementById('addForm');
            
            // Cihaz tipi seçim alanını güncelle
            const typeSelect = form.querySelector('select[name="type"]');
            typeSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                ${deviceTypes.map(type => `
                    <option value="${type.value}" ${type.value === selectedType ? 'selected' : ''}>
                        ${type.label}
                    </option>
                `).join('')}
            `;
            
            // İşletim sistemi seçim alanını güncelle
            const osSelect = form.querySelector('select[name="os"]');
            osSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                ${operatingSystems.map(os => `
                    <option value="${os.value}" ${os.value === selectedOs ? 'selected' : ''}>
                        ${os.label}
                    </option>
                `).join('')}
            `;
            
            // Versiyon seçim alanını güncelle
            if (selectedOs) {
                updateOsVersions(selectedOs, selectedOsVersion);
            }
            
            // Grup seçim alanını güncelle
            const existingGroup = form.querySelector('.form-group:has(select[name="group"])');
            if (existingGroup) {
                existingGroup.remove();
            }
            
            const formGroup = document.createElement('div');
            formGroup.className = 'form-group';
            formGroup.innerHTML = `
                <label>Grup (Opsiyonel)</label>
                <select name="group">
                    <option value="">Grupsuz</option>
                    ${groups.map(g => `
                        <option value="${g.name}" ${g.name === selectedGroup ? 'selected' : ''}>
                            ${g.name}
                        </option>
                    `).join('')}
                </select>
            `;
            
            // IP adresi alanından önce ekle
            const ipInput = form.querySelector('input[name="ip"]').closest('.form-group');
            ipInput.parentNode.insertBefore(formGroup, ipInput);

            // IP adresi alanından önce etki alanı bilgilerini ekle
            const domainFields = document.createElement('div');
            domainFields.className = 'form-row';
            domainFields.innerHTML = `
                <div class="form-group">
                    <label>Etki Alanı</label>
                    <input type="text" name="domain" placeholder="örn: domain.local" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Etki Alanı Cihaz Adı</label>
                    <input type="text" name="domainComputerName" placeholder="örn: PC01" autocomplete="off">
                </div>
            `;

            const credentialsFields = document.createElement('div');
            credentialsFields.className = 'form-row';
            credentialsFields.innerHTML = `
                <div class="form-group">
                    <label>Etki Alanı Kullanıcı Adı</label>
                    <input type="text" name="domainUsername" placeholder="örn: administrator" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Etki Alanı Kullanıcı Parolası</label>
                    <input type="password" name="domainPassword" autocomplete="new-password">
                </div>
            `;

            // IP adresi alanından önce ekle
            ipInput.parentNode.insertBefore(credentialsFields, ipInput);
            ipInput.parentNode.insertBefore(domainFields, credentialsFields);
        }

        // İşletim sistemi değiştiğinde versiyonları güncelle
        function updateOsVersions(osValue, selectedVersion = '') {
            const form = document.getElementById('addForm');
            const versionSelect = form.querySelector('select[name="osVersion"]');
            
            if (!osValue) {
                versionSelect.innerHTML = '<option value="">Önce işletim sistemi seçin</option>';
                versionSelect.disabled = true;
                return;
            }
            
            const os = operatingSystems.find(os => os.value === osValue);
            if (os && os.versions) {
                versionSelect.innerHTML = `
                    <option value="">Seçiniz...</option>
                    ${os.versions.map(version => `
                        <option value="${version.value}" ${version.value === selectedVersion ? 'selected' : ''}>
                            ${version.label}
                        </option>
                    `).join('')}
                `;
                versionSelect.disabled = false;
            }
        }

        // Sekme değiştirme fonksiyonu
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('active');
            });
            
            document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
            document.getElementById(tabId).classList.add('active');
            
            if (tabId === 'groups') {
                updateGroupsList();
            }
        }

        // Grup listesini güncelle
        function updateGroupsList() {
            const groupsList = document.querySelector('.groups-list');
            
            groupsList.innerHTML = groups.map(group => {
                const groupDevices = devices.filter(d => d.group === group.name);
                const onlineCount = groupDevices.filter(d => d.status).length;
                
                return `
                    <div class="group-item" data-group="${group.name}">
                        <div class="group-info">
                            <div class="group-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="group-details">
                                <div class="group-name">${group.name}</div>
                                <input type="text" class="group-edit-input" value="${group.name}">
                                <div class="group-stats">
                                    ${groupDevices.length} Cihaz (${onlineCount} Çevrimiçi)
                                </div>
                            </div>
                        </div>
                        <div class="group-actions">
                            <button class="group-btn edit-group" onclick="editGroup('${group.name}')" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="group-btn delete-group" onclick="deleteGroup('${group.name}')" title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('') || '<div class="no-groups">Henüz grup eklenmemiş</div>';
        }

        // Grup düzenleme
        function editGroup(groupName) {
            const groupItem = document.querySelector(`[data-group="${groupName}"]`);
            const nameSpan = groupItem.querySelector('.group-name');
            const input = groupItem.querySelector('.group-edit-input');
            const editBtn = groupItem.querySelector('.edit-group');
            
            if (nameSpan.classList.contains('editing')) {
                // Kaydet
                const newName = input.value.trim();
                if (newName && newName !== groupName) {
                    // Grup adını güncelle
                    const groupIndex = groups.findIndex(g => g.name === groupName);
                    if (groupIndex !== -1) {
                        groups[groupIndex].name = newName;
                        localStorage.setItem('groups', JSON.stringify(groups));
                        
                        // Cihazların grup adlarını güncelle
                    devices = devices.map(device => ({
                        ...device,
                        group: device.group === groupName ? newName : device.group
                    }));
                    localStorage.setItem('devices', JSON.stringify(devices));
                    }
                    updateGroupsList();
                    updateDevices();
                }
                
                nameSpan.classList.remove('editing');
                input.classList.remove('editing');
                editBtn.innerHTML = '<i class="fas fa-edit"></i>';
            } else {
                // Düzenleme moduna geç
                nameSpan.classList.add('editing');
                input.classList.add('editing');
                editBtn.innerHTML = '<i class="fas fa-save"></i>';
                input.focus();
            }
        }

        // Grup silme
        function deleteGroup(groupName) {
            if (!confirm(`"${groupName}" grubunu silmek istediğinizden emin misiniz?`)) return;
            
            // Grubu sil
            groups = groups.filter(g => g.name !== groupName);
            localStorage.setItem('groups', JSON.stringify(groups));
            
            // Cihazların grup bilgisini güncelle
            devices = devices.map(device => ({
                ...device,
                group: device.group === groupName ? null : device.group
            }));
            localStorage.setItem('devices', JSON.stringify(devices));
            
            updateGroupsList();
            updateDevices();
        }

        // Yeni grup ekleme
        document.getElementById('groupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const groupName = this.elements.groupName.value.trim();
            
            if (!groupName) return;
            
            if (groups.some(g => g.name === groupName)) {
                alert('Bu grup zaten mevcut!');
                return;
            }
            
            // Yeni grup objesi
            const newGroup = {
                id: Date.now().toString(),
                name: groupName,
                createdAt: new Date().toISOString()
            };
            
            groups.push(newGroup);
            localStorage.setItem('groups', JSON.stringify(groups));
            
            this.reset();
            updateGroupsList();
        });

        // Sekme değiştirme olayı
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                switchTab(btn.dataset.tab);
            });
        });

        // Cihaz tipi değiştiğinde markaları güncelle
        function updateBrandOptions(deviceType) {
            const form = document.getElementById('addForm');
            const brandSelect = form.querySelector('select[name="brand"]');
            const modelSelect = form.querySelector('select[name="model"]');
            
            // Cihaz tipine uygun markaları filtrele
            const availableBrands = deviceBrands.filter(brand => 
                brand.categories.includes(deviceType)
            );
            
            brandSelect.innerHTML = `
                <option value="">Seçiniz...</option>
                ${availableBrands.map(brand => `
                    <option value="${brand.value}">${brand.label}</option>
                `).join('')}
            `;
            
            // Model seçimini sıfırla
            modelSelect.innerHTML = '<option value="">Önce marka seçin</option>';
            modelSelect.disabled = true;
            
            brandSelect.disabled = !deviceType;
        }

        // Marka değiştiğinde modelleri güncelle
        function updateModelOptions(brandValue, selectedModel = '') {
            const form = document.getElementById('addForm');
            const deviceType = form.querySelector('select[name="type"]').value;
            const modelSelect = form.querySelector('select[name="model"]');
            
            if (!brandValue) {
                modelSelect.innerHTML = '<option value="">Önce marka seçin</option>';
                modelSelect.disabled = true;
                return;
            }
            
            const brand = deviceBrands.find(b => b.value === brandValue);
            if (brand) {
                // Seçili cihaz tipine uygun modelleri filtrele
                const availableModels = brand.models.filter(model => 
                    model.type === deviceType
                );
                
                // Diğer ve Bilinmeyen seçeneklerini ekle
                const additionalOptions = [
                    { value: `other_${deviceType}`, label: 'Diğer', type: deviceType },
                    { value: `unknown_${deviceType}`, label: 'Bilinmeyen', type: deviceType }
                ];
                
                const allModels = [...availableModels, ...additionalOptions];
                
                modelSelect.innerHTML = `
                    <option value="">Seçiniz...</option>
                    ${allModels.map(model => `
                        <option value="${model.value}" ${model.value === selectedModel ? 'selected' : ''}>
                            ${model.label}
                        </option>
                    `).join('')}
                    <optgroup label="──────────"></optgroup>
                    <option value="other_${deviceType}" ${selectedModel === `other_${deviceType}` ? 'selected' : ''}>
                        Diğer
                    </option>
                    <option value="unknown_${deviceType}" ${selectedModel === `unknown_${deviceType}` ? 'selected' : ''}>
                        Bilinmeyen
                    </option>
                `;
                modelSelect.disabled = false;
            }
        }

        // Ayarlar modalı HTML'ine ses sekmesini ekle
        function createSettingsModal() {
            const modal = document.createElement('div');
            modal.id = 'settingsModal';
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Ayarlar</div>
                        <button class="close-modal" onclick="closeSettingsModal()">×</button>
                    </div>
                    <div class="tabs">
                        <button class="tab-btn active" data-tab="general">Genel</button>
                        <button class="tab-btn" data-tab="groups">Gruplar</button>
                        <button class="tab-btn" data-tab="sound">Ses</button>
                    </div>
                    <div class="tab-content">
                        <!-- Genel sekmesi -->
                        <div class="tab-pane active" id="general">
                            <!-- Mevcut genel ayarlar -->
                        </div>
                        
                        <!-- Gruplar sekmesi -->
                        <div class="tab-pane" id="groups">
                            <!-- Mevcut grup ayarları -->
                        </div>
                        
                        <!-- Ses sekmesi -->
                        <div class="tab-pane" id="sound">
                            <form class="modal-form" id="soundSettingsForm">
                                <div class="form-group">
                                    <label class="switch-label">
                                        <label class="switch">
                                            <input type="checkbox" name="soundEnabled">
                                            <span class="switch-slider"></span>
                                        </label>
                                        <span>Sesli Bildirimler</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Ses Seviyesi</label>
                                    <div class="range-container">
                                        <input type="range" name="volume" min="0" max="1" step="0.1" value="1">
                                        <span class="range-value">100%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Konuşma Hızı</label>
                                    <div class="range-container">
                                        <input type="range" name="rate" min="0.1" max="2" step="0.1" value="1">
                                        <span class="range-value">100%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Ses Tonu</label>
                                    <div class="range-container">
                                        <input type="range" name="pitch" min="0" max="2" step="0.1" value="1">
                                        <span class="range-value">100%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Dil</label>
                                    <select name="language">
                                        <option value="tr-TR">Türkçe</option>
                                        <option value="en-US">İngilizce</option>
                                    </select>
                                </div>
                                <div class="button-group">
                                    <button type="submit" class="save-btn">
                                        <i class="fas fa-save"></i> Kaydet
                                    </button>
                                    <button type="button" class="test-sound-btn" onclick="testSoundSettings()">
                                        <i class="fas fa-volume-up"></i> Test Et
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            return modal;
        }

        // Ses ayarları için JavaScript fonksiyonları
        function loadSoundSettings() {
            const form = document.getElementById('soundSettingsForm');
            if (!form) return;
            
            form.elements.soundEnabled.checked = settings.sound.enabled;
            form.elements.volume.value = settings.sound.volume;
            form.elements.rate.value = settings.sound.rate;
            form.elements.pitch.value = settings.sound.pitch;
            form.elements.language.value = settings.sound.language;
            
            updateRangeValues();
            
            // Form submit olayını dinle
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                saveSoundSettings();
                alert('Ses ayarları kaydedildi!');
            });
        }

        function updateRangeValues() {
            const form = document.getElementById('soundSettingsForm');
            form.querySelectorAll('input[type="range"]').forEach(range => {
                const valueSpan = range.nextElementSibling;
                valueSpan.textContent = `${Math.round(range.value * 100)}%`;
                
                range.addEventListener('input', () => {
                    valueSpan.textContent = `${Math.round(range.value * 100)}%`;
                });
            });
        }

        function testSoundSettings() {
            const form = document.getElementById('soundSettingsForm');
            const testSettings = {
                enabled: form.elements.soundEnabled.checked,
                volume: parseFloat(form.elements.volume.value),
                rate: parseFloat(form.elements.rate.value),
                pitch: parseFloat(form.elements.pitch.value),
                language: form.elements.language.value
            };
            
            if (!testSettings.enabled) return;
            
            const message = testSettings.language === 'tr-TR' ? 
                'Ses ayarları test ediliyor' : 
                'Testing sound settings';
            
            const utterance = new SpeechSynthesisUtterance(message);
            utterance.volume = testSettings.volume;
            utterance.rate = testSettings.rate;
            utterance.pitch = testSettings.pitch;
            utterance.lang = testSettings.language;
            
            window.speechSynthesis.speak(utterance);
        }

        function saveSoundSettings() {
            const form = document.getElementById('soundSettingsForm');
            
            settings.sound = {
                enabled: form.elements.soundEnabled.checked,
                volume: parseFloat(form.elements.volume.value),
                rate: parseFloat(form.elements.rate.value),
                pitch: parseFloat(form.elements.pitch.value),
                language: form.elements.language.value
            };
            
            localStorage.setItem('settings', JSON.stringify(settings));
        }

        // Ayarlar modalını açarken ses ayarlarını yükle
        function openSettingsModal() {
            document.getElementById('settingsModal').style.display = 'block';
            updateSettingsForm(); // Genel ayarları yükle
            loadSoundSettings(); // Ses ayarlarını yükle
        }

        // Ayarlar kaydedilirken ses ayarlarını da kaydet
        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveSoundSettings();
            // ... diğer ayarların kaydedilmesi
        });

        // Yenileme butonu için animasyon
        document.querySelector('.refresh-btn').addEventListener('click', function() {
            this.querySelector('i').style.animation = 'spin 1s linear';
            setTimeout(() => {
                this.querySelector('i').style.animation = '';
            }, 1000);
        });

        // Spin animasyonu için CSS ekle
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

        // Yardım modalını göster
        function showHelp() {
            const existingModal = document.getElementById('helpModal');
            if (!existingModal) {
                document.body.appendChild(createHelpModal());
                
                // Stilleri ekle
                if (!document.getElementById('helpStyles')) {
                    const style = document.createElement('style');
                    style.id = 'helpStyles';
                    style.textContent = helpStyles;
                    document.head.appendChild(style);
                }
            }
            document.getElementById('helpModal').style.display = 'block';
        }

        // Yardım modalını kapat
        function closeHelpModal() {
            document.getElementById('helpModal').style.display = 'none';
        }

        // Yardım modalı HTML'ini oluştur
        function createHelpModal() {
            const modal = document.createElement('div');
            modal.id = 'helpModal';
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content help-content">
                    <div class="modal-header">
                        <div class="modal-title">Yardım ve Bilgi</div>
                        <button class="close-modal" onclick="closeHelpModal()">×</button>
                    </div>
                    <div class="help-sections">
                        <div class="help-section">
                            <h3><i class="fas fa-info-circle"></i> Genel Kullanım</h3>
                            <ul>
                                <li><strong>Cihaz Ekle:</strong> Yeni ağ cihazı eklemek için kullanılır</li>
                                <li><strong>Gruplar:</strong> Cihazları kategorilere ayırmak için kullanılır</li>
                                <li><strong>Ayarlar:</strong> Sistem ayarlarını özelleştirmek için kullanılır</li>
                                <li><strong>Yenile:</strong> Tüm cihazların durumunu manuel kontrol eder</li>
                                <li><strong>İçe/Dışa Aktar:</strong> Sistem verilerini yedekler veya geri yükler</li>
                            </ul>
                        </div>
                        
                        <div class="help-section">
                            <h3><i class="fas fa-keyboard"></i> Klavye Kısayolları</h3>
                            <ul>
                                <li><strong>Ctrl + A:</strong> Yeni cihaz ekleme penceresini açar</li>
                                <li><strong>Ctrl + G:</strong> Grup yönetimi penceresini açar</li>
                                <li><strong>Ctrl + S:</strong> Ayarlar penceresini açar</li>
                                <li><strong>F5:</strong> Sayfayı yeniler</li>
                                <li><strong>Esc:</strong> Açık olan pencereyi kapatır</li>
                            </ul>
                        </div>

                        <div class="help-section">
                            <h3><i class="fas fa-chart-line"></i> Ping Durumları</h3>
                            <ul>
                                <li><span class="status excellent">Mükemmel:</span> 0-15ms arası</li>
                                <li><span class="status good">İyi:</span> 16-35ms arası</li>
                                <li><span class="status warning">Orta:</span> 36-50ms arası</li>
                                <li><span class="status critical">Kritik:</span> 50ms üzeri</li>
                            </ul>
                        </div>

                        <div class="help-section">
                            <h3><i class="fas fa-code"></i> Geliştirici Bilgileri</h3>
                            <div class="developer-info">
                                <p><strong>Versiyon:</strong> 1.0.0</p>
                                <p><strong>Geliştirici:</strong> Talha KARA</p>
                                <p><strong>İletişim:</strong> <a href="mailto:talhakara6@gmail.com">talhakara6@gmail.com</a></p>
                                <p><strong>GitHub:</strong> <a href="https://github.com/talhakara/netmonitoring" target="_blank">github.com/talhakara/netmonitoring</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return modal;
        }

        // CSS stillerini ekle
        const helpStyles = `
            .help-content {
                max-width: 600px;
            }

            .help-sections {
                padding: 20px;
                max-height: 70vh;
                overflow-y: auto;
            }

            .help-section {
                margin-bottom: 25px;
            }

            .help-section h3 {
                font-size: 16px;
                margin-bottom: 15px;
                color: var(--text-color);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .help-section h3 i {
                color: #3498db;
            }

            .help-section ul {
                list-style: none;
                padding: 0;
            }

            .help-section li {
                margin-bottom: 10px;
                padding-left: 20px;
                position: relative;
                line-height: 1.5;
            }

            .help-section li:before {
                content: "•";
                position: absolute;
                left: 0;
                color: #3498db;
            }

            .help-section .status {
                padding: 2px 8px;
                border-radius: 4px;
                font-weight: 500;
            }

            .status.excellent { background: var(--card-ping-excellent); color: var(--border-ping-excellent); }
            .status.good { background: var(--card-ping-good); color: var(--border-ping-good); }
            .status.warning { background: var(--card-ping-warning); color: var(--border-ping-warning); }
            .status.critical { background: var(--card-ping-critical); color: var(--border-ping-critical); }

            .developer-info {
                background: var(--hover-color);
                padding: 15px;
                border-radius: 8px;
                margin-top: 10px;
            }

            .developer-info p {
                margin: 8px 0;
            }

            .developer-info a {
                color: #3498db;
                text-decoration: none;
            }

            .developer-info a:hover {
                text-decoration: underline;
            }
        `;
    </script>
</body>
</html> 