# Guía Anypoint Studio — Consumo REST (Slim) + SOAP (NuSOAP)

Prerrequisitos:

1. MySQL XAMPP activo y BD `arca_soa_db` creada (`sql/schema.sql`)
2. Slim/NuSOAP en `http://localhost:8080`

```powershell
cd servicios-slim
C:\xampp\php\php.exe -S localhost:8080 -t public
```

## 1. Proyecto Mule

- Name: `orquestacion-despacho-lindley`
- Flow: `despachoOrquestadorFlow`
- **HTTP Listener**: `POST /api/despacho/orquestar` puerto `8081`

Body de entrada:

```json
{
  "idPedido": "PED-001",
  "idCliente": "CLI-001",
  "idProducto": "SKU_IK_1.5L",
  "cantidad": 10
}
```

Variables: `idPedido`, `idCliente`, `idProducto`, `cantidad`.

## 2. Consumir REST (HTTP Request)

Host `localhost`, port `8080`.

| Servicio | Method | Path |
|----------|--------|------|
| Inventario | GET | `/api/wms/inventario/validar?id_producto=#[vars.idProducto]&cantidad=#[vars.cantidad]` |
| Picking | POST | `/api/wms/picking` |
| Bahía | POST | `/api/logistica/bahias` |
| Rutas | POST | `/api/tms/rutas/optimizar` |
| Recepción | POST | `/api/cliente/recepciones` |

POST body JSON: `{"idPedido": "#[vars.idPedido]"}`

## 3. Consumir SOAP (Web Service Consumer) — recomendado

Como NuSOAP publica **WSDL**, usa el conector **Web Service Consumer**:

| Servicio | WSDL URL | Operación |
|----------|----------|-----------|
| Validación cliente | `http://localhost:8080/soap/validacionCliente.php?wsdl` | `validarCliente` |
| Sincronización | `http://localhost:8080/soap/sincronizacionErpWms.php?wsdl` | `sincronizarPedido` |
| Guía | `http://localhost:8080/soap/generacionGuia.php?wsdl` | `generarGuia` |
| Cierre ERP | `http://localhost:8080/soap/cierrePedidoErp.php?wsdl` | `cerrarPedido` |
| Auditoría | `http://localhost:8080/soap/auditoria.php?wsdl` | `registrarAuditoria` |

En Studio:

1. Arrastra **Web Service Consumer**
2. Configuration → WSDL Location = URL `...?wsdl`
3. Service / Port / Operation según el WSDL
4. Mapea parámetros (`idCliente`, `idPedido`, etc.) desde `vars`

### Alternativa: HTTP Request + XML

Si el Web Service Consumer falla con RPC/encoded, usa HTTP Request a la URL del `.php` (sin `?wsdl`) con body de `ejemplos/soap-envelopes.md`.

## 4. Orden del flow

```
Listener
→ SOAP ValidacionCliente
→ SOAP SincronizacionERP_WMS
→ REST ValidacionInventario
→ REST GeneracionPicking
→ REST AsignacionBahia
→ SOAP GeneracionGuia
→ REST OptimizacionRutas
→ REST RecepcionCliente
→ SOAP CierrePedidoERP
→ SOAP AuditoriaTransacciones
→ Transform Message (JSON consolidado)
```

## 5. Demo

```http
POST http://localhost:8081/api/despacho/orquestar
Content-Type: application/json

{
  "idPedido": "PED-001",
  "idCliente": "CLI-001",
  "idProducto": "SKU_IK_1.5L",
  "cantidad": 10
}
```

Verifica en MySQL que se insertaron filas:

```sql
USE arca_soa_db;
SELECT * FROM t_validacion_cliente;
SELECT * FROM t_auditoria;
```

## 6. Texto para el informe

> Los servicios REST se implementaron con Slim Framework (JSON/HTTP). Los servicios SOAP se implementaron con NuSOAP, publicando contratos WSDL y persistiendo operaciones en MySQL, siguiendo el patrón del curso (config, models, soap_server, configureWSDL). Anypoint Studio consume ambos protocolos: HTTP Request para REST y Web Service Consumer (WSDL) para SOAP, orquestando el proceso de despacho de Arca Continental Lindley.
