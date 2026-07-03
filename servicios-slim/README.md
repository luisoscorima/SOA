# Servicios SOA — Arca Continental Lindley

Stack alineado al curso:

| Capa | Tecnología |
|------|------------|
| REST (5) | **Slim Framework** |
| SOAP (5) | **NuSOAP** (`econea/nusoap`) + **MySQL** |
| Orquestación | **Anypoint Studio** (consumo) |

## Estructura (como el ejemplo del profesor)

```
servicios-slim/
  config/conexion.php      # PDO MySQL
  models/                  # Lógica + INSERT
  public/
    index.php              # Rutas REST (Slim)
    soap/
      validacionCliente.php
      sincronizacionErpWms.php
      generacionGuia.php
      cierrePedidoErp.php
      auditoria.php
  sql/schema.sql           # BD arca_soa_db
```

## Requisitos

1. PHP 8+ (XAMPP) con extensiones `pdo_mysql`, `soap`, `zip`
2. MySQL de XAMPP en ejecución
3. Composer

## Arranque

```powershell
# 1) MySQL (XAMPP Control Panel → Start MySQL)
# 2) Crear BD (solo la primera vez)
Get-Content sql\schema.sql -Raw | C:\xampp\mysql\bin\mysql.exe -u root

# 3) Dependencias (si falta vendor/)
C:\xampp\php\php.exe composer.phar install

# 4) Servidor
C:\xampp\php\php.exe -S localhost:8080 -t public
```

Catálogo: http://localhost:8080/

## REST (Slim)

| Servicio | Método | URL |
|----------|--------|-----|
| Svc_ValidacionInventario | GET | `/api/wms/inventario/validar?id_producto=SKU_IK_1.5L&cantidad=10` |
| Svc_GeneracionPicking | POST | `/api/wms/picking` |
| Svc_AsignacionBahia | POST | `/api/logistica/bahias` |
| Svc_OptimizacionRutas | POST | `/api/tms/rutas/optimizar` |
| Svc_RecepcionCliente | POST | `/api/cliente/recepciones` |

## SOAP (NuSOAP + WSDL)

| Servicio | Endpoint | WSDL |
|----------|----------|------|
| Svc_ValidacionCliente | `/soap/validacionCliente.php` | `?wsdl` |
| Svc_SincronizacionERP_WMS | `/soap/sincronizacionErpWms.php` | `?wsdl` |
| Svc_GeneracionGuia | `/soap/generacionGuia.php` | `?wsdl` |
| Svc_CierrePedidoERP | `/soap/cierrePedidoErp.php` | `?wsdl` |
| Svc_AuditoriaTransacciones | `/soap/auditoria.php` | `?wsdl` |

Ejemplo WSDL: http://localhost:8080/soap/validacionCliente.php?wsdl

Envelopes XML: `ejemplos/soap-envelopes.md`  
Guía Anypoint: `ANYPOINT.md`  
**Guía completa (informe + demo en vivo):** `GUIA-PASO-A-PASO.md`

## Base de datos

- BD: `arca_soa_db`
- Usuario: `root` (sin contraseña, default XAMPP)
- Tablas: `t_validacion_cliente`, `t_sincronizacion_erp_wms`, `t_generacion_guia`, `t_cierre_pedido_erp`, `t_auditoria`
