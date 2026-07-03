# Prueba 5 REST (Slim) + 5 SOAP (NuSOAP). Requiere :8080 y MySQL.
$base = "http://localhost:8080"
$ok = 0
$fail = 0

function Assert-Ok($name, $script) {
    try {
        & $script | Out-Null
        Write-Host "[OK] $name" -ForegroundColor Green
        $script:ok++
    } catch {
        Write-Host "[FAIL] $name : $($_.Exception.Message)" -ForegroundColor Red
        $script:fail++
    }
}

Assert-Ok "Catalogo" { Invoke-RestMethod "$base/" }
Assert-Ok "REST Inventario" { Invoke-RestMethod "$base/api/wms/inventario/validar?id_producto=SKU_IK_1.5L&cantidad=10" }
Assert-Ok "REST Picking" { Invoke-RestMethod "$base/api/wms/picking" -Method POST -ContentType "application/json" -Body '{"idPedido":"PED-001"}' }
Assert-Ok "REST Bahia" { Invoke-RestMethod "$base/api/logistica/bahias" -Method POST -ContentType "application/json" -Body '{"idPedido":"PED-001"}' }
Assert-Ok "REST Rutas" { Invoke-RestMethod "$base/api/tms/rutas/optimizar" -Method POST -ContentType "application/json" -Body '{"idPedido":"PED-001"}' }
Assert-Ok "REST Recepcion" { Invoke-RestMethod "$base/api/cliente/recepciones" -Method POST -ContentType "application/json" -Body '{"idPedido":"PED-001"}' }

function Invoke-Soap($path, $ns, $innerXml) {
    $body = @"
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="$ns" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>$innerXml</SOAP-ENV:Body>
</SOAP-ENV:Envelope>
"@
    Invoke-WebRequest -Uri "$base$path" -Method POST -ContentType "text/xml; charset=utf-8" -Body $body -UseBasicParsing
}

Assert-Ok "WSDL ValidacionCliente" { Invoke-WebRequest "$base/soap/validacionCliente.php?wsdl" -UseBasicParsing }
Assert-Ok "SOAP ValidacionCliente" {
    Invoke-Soap "/soap/validacionCliente.php" "ValidacionClienteSOAP" '<ns1:validarCliente><idCliente xsi:type="xsd:string">CLI-001</idCliente></ns1:validarCliente>'
}
Assert-Ok "SOAP Sincronizacion" {
    Invoke-Soap "/soap/sincronizacionErpWms.php" "SincronizacionErpWmsSOAP" '<ns1:sincronizarPedido><idPedido xsi:type="xsd:string">PED-001</idPedido></ns1:sincronizarPedido>'
}
Assert-Ok "SOAP Guia" {
    Invoke-Soap "/soap/generacionGuia.php" "GeneracionGuiaSOAP" '<ns1:generarGuia><idPedido xsi:type="xsd:string">PED-001</idPedido></ns1:generarGuia>'
}
Assert-Ok "SOAP Cierre" {
    Invoke-Soap "/soap/cierrePedidoErp.php" "CierrePedidoErpSOAP" '<ns1:cerrarPedido><idPedido xsi:type="xsd:string">PED-001</idPedido></ns1:cerrarPedido>'
}
Assert-Ok "SOAP Auditoria" {
    Invoke-Soap "/soap/auditoria.php" "AuditoriaTransaccionesSOAP" '<ns1:registrarAuditoria><operacion xsi:type="xsd:string">CIERRE</operacion><idPedido xsi:type="xsd:string">PED-001</idPedido></ns1:registrarAuditoria>'
}

Write-Host "`nResultado: $ok OK, $fail FAIL"
exit $(if ($fail -gt 0) { 1 } else { 0 })
