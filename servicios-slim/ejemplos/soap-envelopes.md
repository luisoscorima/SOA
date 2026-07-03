# Envelopes SOAP (NuSOAP) — Postman / Anypoint

Base URL: `http://localhost:8080`  
Header: `Content-Type: text/xml; charset=utf-8`

Cada servicio publica WSDL en `?wsdl` (para **Web Service Consumer** en Anypoint).

## WSDL

| Servicio | WSDL |
|----------|------|
| Validación cliente | `http://localhost:8080/soap/validacionCliente.php?wsdl` |
| Sincronización ERP–WMS | `http://localhost:8080/soap/sincronizacionErpWms.php?wsdl` |
| Generación guía | `http://localhost:8080/soap/generacionGuia.php?wsdl` |
| Cierre pedido ERP | `http://localhost:8080/soap/cierrePedidoErp.php?wsdl` |
| Auditoría | `http://localhost:8080/soap/auditoria.php?wsdl` |

## 1. Validación de cliente

`POST /soap/validacionCliente.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:ns1="ValidacionClienteSOAP"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>
    <ns1:validarCliente>
      <idCliente xsi:type="xsd:string">CLI-001</idCliente>
    </ns1:validarCliente>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

## 2. Sincronización ERP–WMS

`POST /soap/sincronizacionErpWms.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:ns1="SincronizacionErpWmsSOAP"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>
    <ns1:sincronizarPedido>
      <idPedido xsi:type="xsd:string">PED-001</idPedido>
    </ns1:sincronizarPedido>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

## 3. Generación de guía SUNAT

`POST /soap/generacionGuia.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:ns1="GeneracionGuiaSOAP"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>
    <ns1:generarGuia>
      <idPedido xsi:type="xsd:string">PED-001</idPedido>
    </ns1:generarGuia>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

## 4. Cierre de pedido ERP

`POST /soap/cierrePedidoErp.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:ns1="CierrePedidoErpSOAP"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>
    <ns1:cerrarPedido>
      <idPedido xsi:type="xsd:string">PED-001</idPedido>
    </ns1:cerrarPedido>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

## 5. Auditoría de transacciones

`POST /soap/auditoria.php`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
  xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
  xmlns:ns1="AuditoriaTransaccionesSOAP"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
  SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
  <SOAP-ENV:Body>
    <ns1:registrarAuditoria>
      <operacion xsi:type="xsd:string">CIERRE_DESPACHO</operacion>
      <idPedido xsi:type="xsd:string">PED-001</idPedido>
    </ns1:registrarAuditoria>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```
