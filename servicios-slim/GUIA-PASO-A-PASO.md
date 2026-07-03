# Guía paso a paso: qué implementamos, cómo funciona y qué demostrar

Documento para entender el módulo `servicios-slim`, armar el **informe** y preparar la **demo en vivo** del criterio:

> **Consumo en Anypoint** — demostrar que MuleSoft Anypoint consume los servicios REST y SOAP creados. **[4 pts]**

---

## Paso 0 — Idea general (léelo primero)

Tu proyecto tiene **tres capas**:

```text
┌─────────────────────────────────────────────────────────────┐
│  1. SERVICIOS CREADOS (ustedes los implementaron)           │
│     • 5 REST  → Slim Framework (JSON)                       │
│     • 5 SOAP  → NuSOAP + MySQL (XML + WSDL)                 │
│     Puerto: http://localhost:8080                           │
└──────────────────────────▲──────────────────────────────────┘
                           │ consume (cliente)
┌──────────────────────────┴──────────────────────────────────┐
│  2. ORQUESTADOR (Anypoint Studio / Mule)                    │
│     Llama a los 10 servicios en orden de negocio            │
│     Puerto típico: http://localhost:8081                    │
└──────────────────────────▲──────────────────────────────────┘
                           │ invoca
┌──────────────────────────┴──────────────────────────────────┐
│  3. DEMO (Postman / navegador)                              │
│     Una sola petición al orquestador Mule                   │
└─────────────────────────────────────────────────────────────┘
```

**Frase clave para la defensa:**

> Slim y NuSOAP **exponen** los servicios. Anypoint **consume** esos servicios y orquesta el proceso de despacho de Arca Continental Lindley.

Si solo muestran Slim/NuSOAP, demuestran que **crearon** servicios.  
Si muestran Anypoint llamándolos, demuestran el criterio de **consumo** (los 4 pts).

---

## Paso 1 — Qué servicios elegimos y por qué

Están alineados al proceso del informe (ERP → WMS → carga → TMS → entrega → cierre).

| # | Servicio de negocio | Protocolo | Por qué ese protocolo |
|---|---------------------|-----------|------------------------|
| 1 | Validación de cliente (ERP) | **SOAP** | Integración formal / sistema legado |
| 2 | Sincronización ERP–WMS | **SOAP** | Integración entre sistemas heterogéneos |
| 3 | Validación de inventario (WMS) | **REST** | Consulta operativa ágil |
| 4 | Generación de picking (WMS) | **REST** | Operación de almacén |
| 5 | Asignación de bahía | **REST** | Tarea logística operativa |
| 6 | Generación de guía (SUNAT) | **SOAP** | Integración documentaria/fiscal |
| 7 | Optimización de rutas (TMS) | **REST** | Servicio moderno de transporte |
| 8 | Recepción del cliente | **REST** | Confirmación desde app/cliente |
| 9 | Cierre de pedido (ERP) | **SOAP** | Cierre transaccional en ERP |
| 10 | Auditoría de transacciones | **SOAP** | Registro formal de control |

**Para el informe (1 párrafo):**

> Se implementaron 5 servicios REST con Slim para operaciones operativas (WMS, logística, TMS y cliente) y 5 servicios SOAP con NuSOAP para integraciones con ERP/SUNAT y control, persistiendo en MySQL. Anypoint orquesta ambos protocolos en el flujo de despacho.

---

## Paso 2 — Estructura de carpetas (qué es cada cosa)

```text
servicios-slim/
├── composer.json          → Dependencias (Slim + NuSOAP)
├── config/
│   └── conexion.php       → Conexión PDO a MySQL
├── models/                → Lógica de negocio SOAP + INSERT en BD
├── public/
│   ├── index.php          → Rutas REST (Slim)
│   └── soap/              → Endpoints SOAP (NuSOAP, uno por servicio)
├── sql/
│   └── schema.sql         → Crea la BD y tablas
├── ejemplos/
│   └── soap-envelopes.md  → XML de prueba para Postman
├── ANYPOINT.md            → Cómo consumir desde Mule
└── GUIA-PASO-A-PASO.md    → Este documento
```

### 2.1 `composer.json`

Declara las librerías del curso:

- `slim/slim` + `slim/psr7` → REST
- `econea/nusoap` → SOAP con WSDL

Composer las descarga en `vendor/`. **No editas `vendor/`**; solo usas las librerías.

### 2.2 `config/conexion.php`

Clase `Conectar` (como el ejemplo del profesor):

- Abre conexión PDO a `arca_soa_db`
- Usuario `root`, sin contraseña (default XAMPP)
- Los **models** heredan de esta clase para insertar datos

### 2.3 `models/`

Cada archivo es un servicio SOAP a nivel de negocio:

| Archivo | Método | Tabla MySQL |
|---------|--------|-------------|
| `ValidacionCliente.php` | `validar_cliente` | `t_validacion_cliente` |
| `SincronizacionErpWms.php` | `sincronizar_pedido` | `t_sincronizacion_erp_wms` |
| `GeneracionGuia.php` | `generar_guia` | `t_generacion_guia` |
| `CierrePedidoErp.php` | `cerrar_pedido` | `t_cierre_pedido_erp` |
| `AuditoriaTransacciones.php` | `registrar_auditoria` | `t_auditoria` |

Flujo interno de un model:

1. Conecta a MySQL  
2. Ejecuta `INSERT`  
3. Devuelve un arreglo (`estado`, `mensaje`, ids, etc.)

Ese arreglo lo convierte NuSOAP en **XML de respuesta**.

### 2.4 `public/index.php` (REST)

Aquí vive Slim:

1. Crea la app: `AppFactory::create()`
2. Define rutas `GET` / `POST`
3. Lee query params o body JSON
4. Responde JSON con `Content-Type: application/json`

Los REST **no usan MySQL** en esta versión (respuestas simuladas válidas para demo). Lo importante es el contrato HTTP/JSON.

### 2.5 `public/soap/*.php` (SOAP)

Cada archivo es un servicio NuSOAP independiente, como el `insertData.php` del profesor:

1. Carga NuSOAP: `vendor/econea/nusoap/src/nusoap.php`
2. Crea `soap_server()`
3. `configureWSDL(...)` → genera el contrato
4. `addComplexType(...)` → define la estructura de respuesta
5. `register(...)` → publica la operación
6. Define la función PHP (ej. `validarCliente`)
7. `$server->service(...)` → procesa el XML entrante

**WSDL:** abres `...?wsdl` en el navegador y ves el contrato.  
Eso es lo que Anypoint importa con **Web Service Consumer**.

### 2.6 `sql/schema.sql`

Crea:

- Base de datos `arca_soa_db`
- 5 tablas (una por servicio SOAP)

Sirve para demostrar que SOAP **persiste** datos (como en la clase).

---

## Paso 3 — Cómo funciona un servicio REST (detalle)

Ejemplo: validar inventario.

### Petición

```http
GET http://localhost:8080/api/wms/inventario/validar?id_producto=SKU_IK_1.5L&cantidad=10
```

### Qué pasa por dentro

```text
Postman / Anypoint
       │
       ▼
PHP built-in server (:8080)  →  carpeta public/
       │
       ▼
Slim (index.php) encuentra la ruta GET /api/wms/inventario/validar
       │
       ▼
Lee id_producto y cantidad
       │
       ▼
Arma JSON { estado, mensaje, disponible, servicio, ... }
       │
       ▼
Respuesta HTTP 200 + application/json
```

### Los 5 REST

| Servicio | Método | URL | Qué demuestra |
|----------|--------|-----|----------------|
| Validación inventario | GET | `/api/wms/inventario/validar` | Consulta con query params |
| Generación picking | POST | `/api/wms/picking` | Alta operativa (JSON body) |
| Asignación bahía | POST | `/api/logistica/bahias` | Asignación logística |
| Optimización rutas | POST | `/api/tms/rutas/optimizar` | TMS |
| Recepción cliente | POST | `/api/cliente/recepciones` | Cierre de entrega |

Body típico de los POST:

```json
{
  "idPedido": "PED-001",
  "idCliente": "CLI-001"
}
```

### Qué decir en la defensa (REST)

> “Los servicios REST se implementaron con Slim. Exponen recursos HTTP, intercambian JSON y son ideales para operaciones operativas del WMS, logística, TMS y cliente.”

---

## Paso 4 — Cómo funciona un servicio SOAP (detalle)

Ejemplo: validar cliente.

### Contrato (WSDL)

```text
http://localhost:8080/soap/validacionCliente.php?wsdl
```

El WSDL describe:

- Nombre del servicio
- Operación (`validarCliente`)
- Parámetros de entrada (`idCliente`)
- Estructura de salida (`RespuestaValidacionCliente`)

### Petición (XML)

```http
POST http://localhost:8080/soap/validacionCliente.php
Content-Type: text/xml
```

Body: envelope SOAP (ver `ejemplos/soap-envelopes.md`).

### Qué pasa por dentro

```text
Cliente (Postman / Anypoint Web Service Consumer)
       │  XML SOAP
       ▼
validacionCliente.php (NuSOAP soap_server)
       │
       ▼
Función validarCliente($idCliente)
       │
       ▼
Model ValidacionCliente → INSERT en t_validacion_cliente
       │
       ▼
Retorna array [estado, mensaje, idCliente, ...]
       │
       ▼
NuSOAP serializa a XML (SOAP Response)
```

### Los 5 SOAP

| Archivo | Operación | Tabla |
|---------|-----------|-------|
| `validacionCliente.php` | `validarCliente` | `t_validacion_cliente` |
| `sincronizacionErpWms.php` | `sincronizarPedido` | `t_sincronizacion_erp_wms` |
| `generacionGuia.php` | `generarGuia` | `t_generacion_guia` |
| `cierrePedidoErp.php` | `cerrarPedido` | `t_cierre_pedido_erp` |
| `auditoria.php` | `registrarAuditoria` | `t_auditoria` |

### Qué decir en la defensa (SOAP)

> “Los servicios SOAP usan NuSOAP, publican WSDL y persisten en MySQL. Se reservaron a integraciones ERP/SUNAT y auditoría, donde el contrato formal XML aporta interoperabilidad con sistemas legados.”

---

## Paso 5 — Cómo funciona la base de datos

1. XAMPP inicia MySQL.
2. Se ejecuta una vez `sql/schema.sql` → crea `arca_soa_db` y tablas.
3. Cada llamada SOAP hace un `INSERT`.
4. En la demo puedes abrir phpMyAdmin o consola MySQL y mostrar filas nuevas.

Consulta útil:

```sql
USE arca_soa_db;
SELECT * FROM t_validacion_cliente;
SELECT * FROM t_sincronizacion_erp_wms;
SELECT * FROM t_generacion_guia;
SELECT * FROM t_cierre_pedido_erp;
SELECT * FROM t_auditoria;
```

**Para el informe:** captura de las tablas + explicación de que SOAP escribe en BD.

---

## Paso 6 — Cómo se levantan los servicios (antes de Anypoint)

Hazlo siempre en este orden:

### 6.1 MySQL

XAMPP Control Panel → **Start** en MySQL.

Primera vez (crear BD):

```powershell
cd "C:\Users\LUIS GUSTAVO\Documents\PROYECTOS WEB\SOA\servicios-slim"
Get-Content sql\schema.sql -Raw | C:\xampp\mysql\bin\mysql.exe -u root
```

### 6.2 Servidor PHP

```powershell
cd "C:\Users\LUIS GUSTAVO\Documents\PROYECTOS WEB\SOA\servicios-slim"
C:\xampp\php\php.exe -S localhost:8080 -t public
```

Deja esa ventana abierta.

### 6.3 Verificar catálogo

Navegador: http://localhost:8080/

Debes ver el JSON con la lista de REST y de WSDL SOAP.

### 6.4 Probar un REST

Postman:

```http
GET http://localhost:8080/api/wms/inventario/validar?id_producto=SKU_IK_1.5L&cantidad=10
```

### 6.5 Probar un SOAP

1. Navegador: http://localhost:8080/soap/validacionCliente.php?wsdl  
2. Postman: `POST` al mismo archivo **sin** `?wsdl`, body XML de `ejemplos/soap-envelopes.md`.

Si REST y SOAP responden, los servicios están listos para que Anypoint los consuma.

---

## Paso 7 — Cómo funciona el consumo en Anypoint (los 4 pts)

Aquí está el corazón de la rúbrica.

### 7.1 Rol de Anypoint

Anypoint **no reemplaza** a Slim/NuSOAP.  
Anypoint es el **cliente/orquestador**:

- Recibe una petición de negocio (`POST /api/despacho/orquestar`)
- Llama a los 5 REST (HTTP Request)
- Llama a los 5 SOAP (Web Service Consumer o HTTP Request + XML)
- Devuelve un JSON consolidado

### 7.2 Diagrama del flow Mule

```text
POST /api/despacho/orquestar  (Listener en :8081)
        │
        ├─► SOAP  validarCliente
        ├─► SOAP  sincronizarPedido
        ├─► REST  validar inventario
        ├─► REST  generar picking
        ├─► REST  asignar bahía
        ├─► SOAP  generarGuia
        ├─► REST  optimizar rutas
        ├─► REST  recepción cliente
        ├─► SOAP  cerrarPedido
        └─► SOAP  registrarAuditoria
        │
        ▼
JSON final con todas las respuestas
```

Ese orden sigue el proceso del informe.

### 7.3 Componentes Mule que debes mostrar

| Componente | Para qué |
|------------|----------|
| HTTP Listener | Entrada del orquestador |
| Set Variable | Guardar `idPedido`, `idCliente`, etc. |
| HTTP Request (×5) | Consumir REST en `:8080` |
| Web Service Consumer (×5) | Consumir SOAP vía WSDL |
| Logger | Ver cada respuesta en consola |
| Transform Message | Armar respuesta final |

Detalle técnico: `ANYPOINT.md`.

### 7.4 Qué decir en la defensa (Anypoint)

> “Anypoint actúa como capa de orquestación SOA. Consume servicios REST (JSON) y SOAP (WSDL/XML) ya implementados, sin acoplar la lógica de cada sistema. Así integramos ERP, WMS, TMS y cliente en un solo proceso de despacho.”

---

## Paso 8 — Qué poner en el informe (checklist de contenido)

Copia esta estructura a tu sección de integración / Anypoint:

### 8.1 Arquitectura

- Diagrama de 3 capas (servicios → Anypoint → cliente)
- Tabla de 10 servicios (protocolo + justificación)

### 8.2 Implementación REST

- Slim Framework
- Lista de endpoints
- Ejemplo de request/response JSON (captura Postman)

### 8.3 Implementación SOAP

- NuSOAP + `configureWSDL` + models + MySQL
- Lista de WSDL
- Ejemplo de request/response XML
- Captura de filas en MySQL

### 8.4 Consumo Anypoint

- Captura del flow en Studio (se ven los 10 conectores)
- Captura de configuración HTTP Request (REST)
- Captura de Web Service Consumer con URL `...?wsdl`
- Captura de Postman al orquestador Mule
- Captura de logs Mule

### 8.5 Párrafo listo para pegar

> Para demostrar el consumo desde la plataforma de integración empresarial, se implementaron 10 servicios del proceso de gestión de pedidos y distribución de Arca Continental Lindley: cinco REST con Slim Framework (Validación de inventario, Generación de picking, Asignación de bahía, Optimización de rutas y Recepción del cliente) y cinco SOAP con NuSOAP y MySQL (Validación de cliente, Sincronización ERP–WMS, Generación de guía SUNAT, Cierre de pedido en ERP y Auditoría de transacciones). Los REST atienden operaciones operativas con JSON; los SOAP integraciones formales con contrato WSDL y persistencia. Anypoint Studio orquesta el proceso invocando los diez servicios en secuencia de negocio mediante HTTP Request y Web Service Consumer, consolidando las respuestas en un único resultado de orquestación.

---

## Paso 9 — Guion de la demo en vivo (ensaya esto)

Duración sugerida: **5–8 minutos**.

### Minuto 0–1: Contexto

> “Nuestro proceso es el despacho de Arca Continental Lindley. Implementamos 5 REST con Slim y 5 SOAP con NuSOAP. Anypoint los consume y orquesta.”

Muestra el diagrama (Paso 0).

### Minuto 1–2: Servicios arriba

1. MySQL ON en XAMPP  
2. Terminal con `php -S localhost:8080 -t public`  
3. Navegador: http://localhost:8080/ → catálogo  

### Minuto 2–3: Un REST

Postman GET inventario → JSON `estado: OK`.

> “Este es un servicio REST del WMS.”

### Minuto 3–4: Un SOAP

1. Navegador: `validacionCliente.php?wsdl`  
2. Postman POST con XML  
3. MySQL: `SELECT * FROM t_validacion_cliente;` → fila nueva  

> “Este es SOAP con NuSOAP, WSDL y persistencia en MySQL, como en clase.”

### Minuto 4–7: Anypoint (lo más importante)

1. Muestra el flow en Studio (10 llamadas visibles)  
2. Run del proyecto Mule  
3. Postman:

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

4. Muestra respuesta consolidada  
5. Muestra logs de Mule (cada backend respondió)  
6. Opcional: MySQL con más filas de los SOAP  

### Minuto 7–8: Cierre

> “Anypoint consumió los 5 REST y los 5 SOAP creados por nosotros, orquestando el proceso de despacho de punta a punta.”

---

## Paso 10 — Checklist del día de la presentación

Antes de salir de casa / entrar al aula:

- [ ] XAMPP MySQL inicia sin error  
- [ ] `arca_soa_db` existe (si no, correr `schema.sql`)  
- [ ] `php -S localhost:8080 -t public` responde en el navegador  
- [ ] Postman tiene colección REST + SOAP guardada  
- [ ] Proyecto Mule abre en Anypoint Studio  
- [ ] Puerto `8081` libre para Mule  
- [ ] Capturas de respaldo por si falla la red/demo en vivo  

Si Anypoint falla en el momento, aún puedes:

1. Mostrar los 10 servicios en Postman  
2. Mostrar capturas previas del flow Mule  
3. Explicar el diagrama de consumo  

Pero lo ideal es la orquestación en vivo.

---

## Paso 11 — Errores comunes y qué hacer

| Problema | Causa | Solución |
|----------|--------|----------|
| `Connection refused` en Anypoint | PHP no está corriendo | Levantar `php -S ...` |
| SOAP falla / error PDO | MySQL apagado | Start MySQL en XAMPP |
| WSDL no carga | URL mal escrita | Debe terminar en `.php?wsdl` |
| REST 404 | Path incorrecto | Usar rutas del catálogo `/` |
| Mule no arranca | Puerto ocupado | Cambiar puerto Listener |

---

## Resumen en una frase por capa

| Capa | En una frase |
|------|----------------|
| Slim | Expone 5 APIs REST en JSON |
| NuSOAP | Expone 5 APIs SOAP con WSDL y guarda en MySQL |
| MySQL | Evidencia de que SOAP ejecutó operaciones reales |
| Anypoint | Consume los 10 y orquesta el proceso de despacho |
| Postman | Herramienta para demostrar todo en vivo |

---

## Archivos de apoyo

| Archivo | Úsalo para |
|---------|------------|
| `README.md` | Arranque rápido |
| `ANYPOINT.md` | Armar el flow Mule paso a paso |
| `ejemplos/soap-envelopes.md` | XML listos para Postman |
| `scripts/test-all.ps1` | Probar los 10 servicios de un golpe |
| `GUIA-PASO-A-PASO.md` | Entender, informar y demostrar (este archivo) |
