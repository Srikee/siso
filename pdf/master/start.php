<html>

<head>
    <style>
    body {}

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-bold {
        font-weight: bold;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .answer {
        border-bottom: 1px dotted #000;
        text-align: center;
        color: #4550d1;
    }

    .table {
        width: 100%;
    }

    .table td {
        vertical-align: top;
    }

    .text-primary {
        color: #4e73df;
    }

    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #dc3545;
    }

    .text-warning {
        color: #ffc107;
    }

    .text-info {
        color: #17a2b8;
    }

    <?php for($i=1; $i<=400; $i++) {
        echo '.size-'.$i.' { font-size: '.$i.'px; }';
        echo '.pd-'.$i.' { padding: '.$i.'px; }';
        echo '.pdt-'.$i.' { padding-top: '.$i.'px; }';
        echo '.pdr-'.$i.' { padding-right: '.$i.'px; }';
        echo '.pdb-'.$i.' { padding-bottom: '.$i.'px; }';
        echo '.pdl-'.$i.' { padding-left: '.$i.'px; }';
        echo '.mg-'.$i.' { margin: '.$i.'px; }';
        echo '.mgt-'.$i.' { margin-top: '.$i.'px; }';
        echo '.mgr-'.$i.' { margin-right: '.$i.'px; }';
        echo '.mgb-'.$i.' { margin-bottom: '.$i.'px; }';
        echo '.mgl-'.$i.' { margin-left: '.$i.'px; }';
        echo '.line-height-'.$i.' { line-height: '.$i.'px; }';
        echo '.wd-'.$i.' { width: '.$i.'px; }';
    }

    ?>
    </style>
</head>

<body>