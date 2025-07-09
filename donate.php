<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los datos del formulario
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Validar que el monto sea positivo
    if ($amount <= 0) {
        die('El monto de la donación debe ser mayor a cero.');
    }

    // Aquí agregarías el procesamiento del pago según el método seleccionado.
    switch ($payment_method) {
        case 'credit_card':
            // Procesar con tarjeta de crédito
            processCreditCardPayment($amount);
            break;

        case 'paypal':
            // Redirigir a PayPal para procesar el pago
            processPayPalPayment($amount);
            break;

        case 'bank_transfer':
            // Aquí podrías procesar la transferencia bancaria (puedes manejarlo como un pago offline)
            processBankTransfer($amount);
            break;

        default:
            die('Método de pago no reconocido.');
    }

    // Después de procesar el pago, guardar la donación en la base de datos
    saveDonation($amount, $payment_method);

    // Redirigir al usuario a una página de confirmación
    header('Location: thank_you.php');
    exit;
}

function processCreditCardPayment($amount) {
    // Aquí iría la integración con una API como Stripe o un gateway de tarjetas.
    echo "Procesando pago con tarjeta de crédito de {$amount} USD... <br>";
    // Llamada a la API de Stripe u otra pasarela para procesar el pago.
}

function processPayPalPayment($amount) {
    // Aquí puedes redirigir al usuario a PayPal con los parámetros necesarios
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=example@paypal.com&amount={$amount}";
    header("Location: {$paypal_url}");
    exit;
}

function processBankTransfer($amount) {
    // Aquí podrías dar instrucciones sobre cómo realizar una transferencia bancaria.
    echo "Por favor realiza la transferencia bancaria de {$amount} USD a nuestra cuenta.";
}

function saveDonation($amount, $payment_method) {
    // Aquí conectarías a la base de datos y guardarías la información de la donación
    // Ejemplo de conexión a una base de datos MySQL (usa PDO para seguridad)
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=donations', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('INSERT INTO donations (amount, payment_method, date) VALUES (?, ?, ?)');
        $stmt->execute([$amount, $payment_method, date('Y-m-d H:i:s')]);

        echo "Donación de {$amount} USD procesada exitosamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
