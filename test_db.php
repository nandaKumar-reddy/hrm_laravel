<?php
try {
    $pdo = new PDO(
        "pgsql:host=localhost;port=5432;dbname=flow",
        "postgres",
        "postgres"
    );
    echo "Connected successfully\n";
    
    // Try to create a test client
    $stmt = $pdo->prepare("INSERT INTO clients (client_id, client_name, email, phone, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute(['TEST001', 'Test Company', 'test@example.com', '1234567890']);
    echo "Test client created successfully\n";
    
    // Verify the client was created
    $result = $pdo->query("SELECT * FROM clients");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
