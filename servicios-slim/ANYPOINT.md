# Guía Anypoint Studio — Consumo de los 10 servicios (5 REST + 5 SOAP)

Un solo flow orquestador. Anypoint **consume** los servicios Slim (REST) y NuSOAP (SOAP) en `127.0.0.1:8080`.

## Prerrequisitos

1. MySQL XAMPP en **Start** y BD `arca_soa_db` creada (`sql/schema.sql`).
2. Slim escuchando en **IPv4** (importante: no uses solo `localhost`):

```powershell
cd "C:\Users\LUIS GUSTAVO\Documents\PROYECTOS WEB\SOA\servicios-slim"
C:\xampp\php\php.exe -S 127.0.0.1:8080 -t public
```

3. Proyecto Mule: `orquestacion-despacho-lindley`.

Componentes de la paleta: **Set Variable**, **Transform Message**, **Request (HTTP)**, **Logger**.  
No hace falta Web Service Consumer: SOAP se consume con HTTP Request + XML.

---

## 1. Listener (entrada del orquestador)

1. Clic en el **Listener**.
2. **Connector configuration** → `HTTP_Listener_config`:
   - **Host:** `0.0.0.0`
   - **Port:** `8081`
   - **Base path:** vacío (o solo `/`) — si pones la ruta aquí y otra vez en Path, se duplica.
3. En el Listener:
   - **Path:** `/api/despacho/orquestar`
   - Method: `POST`

Postman llamará a:

```http
POST http://localhost:8081/api/despacho/orquestar
```

Body:

```json
{
  "idPedido": "PED-001",
  "idCliente": "CLI-001",
  "idProducto": "SKU_IK_1.5L",
  "cantidad": 10
}
```

---

## 2. Variables de entrada

Arrastra 4 **Set Variable** (buscar en paleta: `Set Variable`). Value en modo **fx**:

| Name | Value (fx) |
|------|------------|
| `idPedido` | `payload.idPedido` |
| `idCliente` | `payload.idCliente` |
| `idProducto` | `payload.idProducto` |
| `cantidad` | `payload.cantidad` |

---

## 3. Config HTTP hacia Slim

En el primer **Request**, **Connector configuration** → **+**:

| Campo | Valor |
|-------|--------|
| Name | `HTTP_Request_Slim` |
| Host | `127.0.0.1` |
| Port | `8080` |
| Protocol | `HTTP` |

Reutiliza esta config en los 10 Request.

---

## 4. Orden del Process (los 10 servicios)

```text
Listener
→ variables (idPedido, idCliente, idProducto, cantidad)
→ SOAP cliente
→ SOAP sincronización
→ REST inventario
→ REST picking
→ REST bahía
→ SOAP guía
→ REST rutas
→ REST recepción
→ SOAP cierre
→ SOAP auditoría
→ Transform final (JSON)
```

Cada servicio = **Transform** (si aplica) → **Request** → **Set Variable**.

---

## 5. Patrón SOAP (5 servicios)

Para cada uno:

1. **Transform Message** (script XML de abajo)
2. **Request**
   - Config: `HTTP_Request_Slim`
   - Method: `POST`
   - Path: el `.php` (sin `?wsdl`)
   - Headers (tabla o fx):

```dataweave
%dw 2.0
output application/java
---
{
  "Content-Type": "text/xml; charset=utf-8"
}
```

3. **Set Variable** = `payload` (fx)

### 5.1 Validación cliente → `respCliente`

Path: `/soap/validacionCliente.php`

```dataweave
%dw 2.0
output text/plain
var cliente = vars.idCliente as String default ""
---
'<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="ValidacionClienteSOAP" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:validarCliente><idCliente xsi:type="xsd:string">'
++ cliente ++
'</idCliente></ns1:validarCliente></SOAP-ENV:Body></SOAP-ENV:Envelope>'
```

### 5.2 Sincronización ERP–WMS → `respSync`

Path: `/soap/sincronizacionErpWms.php`

```dataweave
%dw 2.0
output text/plain
var pedido = vars.idPedido as String default ""
---
'<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="SincronizacionErpWmsSOAP" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:sincronizarPedido><idPedido xsi:type="xsd:string">'
++ pedido ++
'</idPedido></ns1:sincronizarPedido></SOAP-ENV:Body></SOAP-ENV:Envelope>'
```

### 5.3 Generación guía → `respGuia`

Path: `/soap/generacionGuia.php`

```dataweave
%dw 2.0
output text/plain
var pedido = vars.idPedido as String default ""
---
'<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="GeneracionGuiaSOAP" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:generarGuia><idPedido xsi:type="xsd:string">'
++ pedido ++
'</idPedido></ns1:generarGuia></SOAP-ENV:Body></SOAP-ENV:Envelope>'
```

### 5.4 Cierre pedido ERP → `respCierre`

Path: `/soap/cierrePedidoErp.php`

```dataweave
%dw 2.0
output text/plain
var pedido = vars.idPedido as String default ""
---
'<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="CierrePedidoErpSOAP" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:cerrarPedido><idPedido xsi:type="xsd:string">'
++ pedido ++
'</idPedido></ns1:cerrarPedido></SOAP-ENV:Body></SOAP-ENV:Envelope>'
```

### 5.5 Auditoría → `respAuditoria`

Path: `/soap/auditoria.php`

```dataweave
%dw 2.0
output text/plain
var pedido = vars.idPedido as String default ""
---
'<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="AuditoriaTransaccionesSOAP" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:registrarAuditoria><operacion xsi:type="xsd:string">CIERRE_DESPACHO</operacion><idPedido xsi:type="xsd:string">'
++ pedido ++
'</idPedido></ns1:registrarAuditoria></SOAP-ENV:Body></SOAP-ENV:Envelope>'
```

> En DataWeave usa `as String` antes del `++`. Si no, Studio marca errores de coerción a Date/Time.

---

## 6. Patrón REST (5 servicios)

### 6.1 Inventario (GET) → `respInventario`

**Request:**

| Campo | Valor |
|-------|--------|
| Config | `HTTP_Request_Slim` |
| Method | `GET` |
| Path | `/api/wms/inventario/validar` |

Query Parameters (**fx** activado):

| Name | Value (fx) |
|------|------------|
| `id_producto` | `vars.idProducto as String` |
| `cantidad` | `vars.cantidad as String` |

**Set Variable:** `respInventario` = `payload` (fx)

### 6.2–6.5 REST POST (picking, bahía, rutas, recepción)

Para cada uno:

1. **Transform Message** (body JSON):

```dataweave
%dw 2.0
output application/json
---
{
  idPedido: vars.idPedido,
  idCliente: vars.idCliente
}
```

2. **Request**
   - Config: `HTTP_Request_Slim`
   - Method: `POST`
   - Headers:

```dataweave
%dw 2.0
output application/java
---
{
  "Content-Type": "application/json"
}
```

3. **Set Variable** = `payload` (fx)

| Display Name | Path | Variable |
|--------------|------|----------|
| `restPicking` | `/api/wms/picking` | `respPicking` |
| `restBahia` | `/api/logistica/bahias` | `respBahia` |
| `restRutas` | `/api/tms/rutas/optimizar` | `respRutas` |
| `restRecepcion` | `/api/cliente/recepciones` | `respRecepcion` |

---

## 7. Checklist de los 10

| # | Tipo | Servicio | Path | Variable |
|---|------|----------|------|----------|
| 1 | SOAP | Validación cliente | `/soap/validacionCliente.php` | `respCliente` |
| 2 | SOAP | Sincronización ERP–WMS | `/soap/sincronizacionErpWms.php` | `respSync` |
| 3 | REST | Validación inventario | `/api/wms/inventario/validar` | `respInventario` |
| 4 | REST | Generación picking | `/api/wms/picking` | `respPicking` |
| 5 | REST | Asignación bahía | `/api/logistica/bahias` | `respBahia` |
| 6 | SOAP | Generación guía | `/soap/generacionGuia.php` | `respGuia` |
| 7 | REST | Optimización rutas | `/api/tms/rutas/optimizar` | `respRutas` |
| 8 | REST | Recepción cliente | `/api/cliente/recepciones` | `respRecepcion` |
| 9 | SOAP | Cierre pedido ERP | `/soap/cierrePedidoErp.php` | `respCierre` |
| 10 | SOAP | Auditoría | `/soap/auditoria.php` | `respAuditoria` |

---

## 8. Transform final

Al final del Process:

```dataweave
%dw 2.0
output application/json
---
{
  idPedido: vars.idPedido,
  mensaje: "Proceso de despacho orquestado correctamente",
  rest: {
    inventario: vars.respInventario,
    picking: vars.respPicking,
    bahia: vars.respBahia,
    rutas: vars.respRutas,
    recepcion: vars.respRecepcion
  },
  soap: {
    cliente: vars.respCliente,
    sincronizacion: vars.respSync,
    guia: vars.respGuia,
    cierre: vars.respCierre,
    auditoria: vars.respAuditoria
  }
}
```

---

## 9. Probar

1. Slim en `127.0.0.1:8080` + MySQL ON.
2. **Run** del proyecto Mule.
3. Postman:

```http
POST http://localhost:8081/api/despacho/orquestar
Content-Type: application/json
```

```json
{
  "idPedido": "PED-001",
  "idCliente": "CLI-001",
  "idProducto": "SKU_IK_1.5L",
  "cantidad": 10
}
```

Éxito: JSON con **5 claves en `rest`** y **5 en `soap`**, todas con `estado: OK`.

MySQL:

```sql
USE arca_soa_db;
SELECT COUNT(*) FROM t_validacion_cliente;
SELECT COUNT(*) FROM t_sincronizacion_erp_wms;
SELECT COUNT(*) FROM t_generacion_guia;
SELECT COUNT(*) FROM t_cierre_pedido_erp;
SELECT COUNT(*) FROM t_auditoria;
```

---

## 10. Errores frecuentes

| Error | Causa | Solución |
|-------|--------|----------|
| `No listener for endpoint` y available = path duplicado | Base path + Path iguales | Base path vacío; Path solo `/api/despacho/orquestar` |
| `Connection refused` a `:8080` | Slim apagado o solo en IPv6 | `php -S 127.0.0.1:8080 -t public` |
| DataWeave `++` / Date / Time | Operandos `Any` | Usar `vars.x as String default ""` |
| Headers en rojo | JSON sin DataWeave | Tabla Name/Value o `output application/java` |
| `id_producto`: `"vars.idProducto as String"` | Query sin modo **fx** | Activar fx en cada query param |
| Amarillo en variables | Metadata incompleta | Se puede ignorar |

---

## 11. Texto para el informe

> Los servicios REST se implementaron con Slim Framework (JSON/HTTP). Los servicios SOAP se implementaron con NuSOAP, publicando contratos WSDL y persistiendo operaciones en MySQL, siguiendo el patrón del curso (config, models, soap_server, configureWSDL). Anypoint Studio orquesta el proceso de despacho de Arca Continental Lindley consumiendo los diez servicios (cinco REST y cinco SOAP) mediante el conector HTTP Request, consolidando las respuestas en un único resultado de orquestación.

---

## Resumen

| Capa | Puerto | Rol |
|------|--------|-----|
| Slim + NuSOAP | `127.0.0.1:8080` | Servicios creados |
| Anypoint (este flow) | `localhost:8081` | Consumo y orquestación |
| Postman | → `:8081` | Demo en vivo |

**No necesitas más flows:** uno solo con los 10 consumos cumple la rúbrica.
