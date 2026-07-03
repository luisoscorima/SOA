Logotipo

Descripción generada automáticamente 

 

 

CURSO: 

Arquitecura De Servicio Soa 

PROFESOR: 

Luis Fernando Bejarano Arenas 

EMPRESA: 

Arca Continental Lindley S.A 

Arca Continental Lindley | LinkedIn 

INTEGRANTES: 

Cordero Castillo, Yosua Mateo		U21201316 

Ramos Valdez, Joe Santos Junior		U20237807 

Mestanza Zegarra Gerson Gerardo		U31319713 

Chavez Vilchez Jonell Gustavo		U19208147 

Oscorima Palomino, Luis Gustavo		U21313503 

 

2026	 

 

Diseño del proceso (Bizagi) 

 

 

 

 

 

 

 

El proceso de gestión de pedidos y distribución de Arca Continental Lindley S.A. inicia cuando el pedido es registrado en el sistema ERP (SAP), desde donde se sincroniza automáticamente con el sistema de gestión de almacenes (WMS). 

 

En la fase de preparación de pedidos, el WMS realiza la planificación de oleadas, genera la lista de picking y ejecuta la recolección de productos. Posteriormente, se lleva a cabo el control de calidad, la consolidación y estibado de los productos, así como el etiquetado de pallets mediante códigos LPN. Finalmente, se valida el inventario disponible para asegurar el cumplimiento del pedido. 

 

En la fase de carga de transporte, se asigna la bahía correspondiente, se valida el transportista y se realiza la carga de la mercancía en el vehículo. Luego, se efectúa el escaneo de la carga para verificar su exactitud. En caso de errores, se procede a la corrección de la carga. Una vez validada, se genera la guía de remisión electrónica a través de SUNAT. 

 

En la fase de distribución logística, el sistema de gestión de transporte (TMS) optimiza la ruta de entrega, activa el monitoreo GPS y gestiona geocercas para el seguimiento en tiempo real. Si se presentan incidencias durante el trayecto, se registran y se realiza un re-ruteo dinámico para garantizar la continuidad del servicio. 

 

En la fase de entrega al cliente, se notifica la llegada del pedido, se realiza la descarga de productos y se valida la conformidad con la factura. En caso de rechazo parcial, se registra la incidencia. Asimismo, se gestionan los envases retornables, se realiza la cobranza y se obtiene la firma digital como evidencia de la entrega. 

 

Finalmente, en la fase de liquidación y cierre, el vehículo retorna al centro de distribución, se realiza la liquidación de documentos y valores, y se procede al cierre del pedido en el sistema ERP, concluyendo así el proceso. 

 

Candidatos a servicios 

En esta sección se identifican los servicios candidatos a partir del proceso de gestión de pedidos y distribución, aplicando principios de la arquitectura orientada a servicios (SOA), tales como reutilización, autonomía, interoperabilidad y bajo acoplamiento. 

 

Los servicios fueron clasificados en servicios de entidad, tarea, utilidad e integración, en función de su rol dentro del proceso. Cada servicio encapsula una funcionalidad específica del negocio y puede ser reutilizado en distintos escenarios dentro de la organización. 

# 

Servicio 

Tipo 

Justificación SOA 

Entrada 

Salida 

Sistema 

1 

Sincronización ERP–WMS 

Integración 

Interoperabilidad: Permite comunicación entre sistemas heterogéneos. Bajo acoplamiento: ERP y WMS funcionan de forma independiente. 

Pedido ERP 

Pedido WMS 

ERP/WMS 

2 

Planificación de oleadas 

Tarea 

Reusabilidad: Puede aplicarse a distintos tipos de pedidos. Autonomía: Encapsula lógica de agrupación. 

Pedidos 

Órdenes agrupadas 

WMS 

3 

Generación de picking 

Tarea 

Encapsulación: Centraliza la lógica de generación de listas. 

Pedido 

Lista picking 

WMS 

4 

Ejecución de picking 

Tarea 

Abstracción: Oculta la complejidad operativa del almacén. 

Lista 

Productos 

WMS 

5 

Control de calidad 

Tarea 

Reusabilidad: Puede aplicarse en múltiples procesos logísticos. 

Productos 

Productos validados 

WMS 

6 

Consolidación y estibado 

Tarea 

Autonomía: Opera independientemente del resto del flujo. 

Productos 

Pallets 

WMS 

7 

Etiquetado LPN 

Entidad 

Estandarización: Permite trazabilidad uniforme. 

Pallet 

Código LPN 

WMS 

8 

Validación de inventario 

Tarea 

Interoperabilidad: Compartido entre ERP y WMS. Reusabilidad: Usado en ventas y logística. 

Stock 

Confirmación 

WMS 

9 

Asignación de bahía 

Tarea 

Autonomía: Lógica independiente de asignación. 

Pedido 

Bahía 

Logística 

10 

Validación de transportista 

Tarea 

Encapsulación: Centraliza validaciones legales. 

Datos 

Validación 

Logística 

11 

Carga de mercancía 

Tarea 

Abstracción: Representa proceso físico como servicio lógico. 

Pallets 

Camión cargado 

Logística 

12 

Escaneo de carga 

Tarea 

Interoperabilidad: Integra datos físicos con sistemas digitales. 

Productos 

Registro 

Logística 

13 

Corrección de carga 

Tarea 

Resiliencia: Permite recuperación ante errores. 

Error 

Corrección 

Logística 

14 

Generación de guía 

Integración 

Interoperabilidad: Conexión con SUNAT. Bajo acoplamiento: Cambios legales no afectan otros sistemas. 

Datos 

Guía 

SUNAT 

15 

Optimización de rutas 

Tarea 

Autonomía: Lógica compleja independiente. Asincronismo: Puede ejecutarse en segundo plano. 

Datos 

Ruta 

TMS 

16 

Activación GPS 

Utilidad 

Stateless: No mantiene estado. 

Vehículo 

Seguimiento 

TMS 

17 

Geocercas 

Utilidad 

Reusabilidad: Aplicable a múltiples monitoreos. 

Ubicación 

Alertas 

TMS 

18 

Registro de incidencias 

Tarea 

Encapsulación: Maneja eventos sin afectar flujo principal. 

Evento 

Registro 

TMS 

19 

Re-ruteo dinámico 

Tarea 

Adaptabilidad: Permite cambios dinámicos. 

Incidencia 

Nueva ruta 

TMS 

20 

Notificación cliente 

Utilidad 

Stateless: Escalable para múltiples usuarios. 

Estado 

Mensaje 

App/SMS 

21 

Descarga de productos 

Tarea 

Abstracción: Representa entrega física. 

Mercancía 

Entrega 

Repartidor 

22 

Validación vs factura 

Tarea 

Consistencia: Garantiza integridad de datos. 

Productos 

Validación 

Repartidor 

23 

Gestión retornables 

Entidad 

Reusabilidad: Aplica a logística inversa. 

Envases 

Registro 

Logística 

24 

Cobranza 

Tarea 

Encapsulación: Centraliza proceso financiero. 

Pedido 

Pago 

Financiero 

25 

Firma digital (POD) 

Utilidad 

Composibilidad: Puede integrarse en múltiples procesos. 

Entrega 

Evidencia 

App 

26 

Recepción cliente 

Tarea 

Interoperabilidad: Integra cliente al sistema. 

Pedido 

Confirmación 

Cliente 

27 

Retorno a CD 

Tarea 

Autonomía: Flujo independiente de cierre. 

Vehículo 

Llegada 

Logística 

28 

Liquidación 

Tarea 

Encapsulación: Consolida documentos y valores. 

Datos 

Liquidación 

Admin 

29 

Validación de cliente 

Entidad 

Reusabilidad: Utilizado en procesos de ventas y despacho. 

Cliente 

Cliente validado 

ERP 

30 

Consulta de estado de pedido 

Utilidad 

Stateless: Permite consultas concurrentes sin mantener sesión. 

Pedido 

Estado 

ERP 

31 

Gestión de devoluciones 

Tarea 

Encapsula procesos de logística inversa y atención de incidencias. 

Devolución 

Registro devolución 

Logística 

32 

Actualización de stock automático 

Integración 

Mantiene sincronización automática entre inventario físico y lógico. 

Movimiento 

Stock actualizado 

ERP/WMS 

33 

Validación de documentos de transporte 

Tarea 

Encapsulación: Centraliza validaciones documentarias antes del despacho. 

Documentos 

Validación 

Logística 

34 

Validación de capacidad vehicular 

Tarea 

Garantiza que la carga cumpla límites físicos del vehículo. 

Peso/volumen 

Validación 

TMS 

35 

Monitoreo de temperatura de carga 

Utilidad 

Reusabilidad: Monitoreo continuo de condiciones de transporte. 

Sensor 

Alerta 

TMS 

36 

Gestión de mantenimiento vehicular 

Entidad 

Centraliza disponibilidad y estado operativo de la flota. 

Vehículo 

Estado mantenimiento 

Flota 

37 

Auditoría de transacciones 

Utilidad 

Trazabilidad y seguimiento de operaciones críticas del sistema. 

Evento 

Registro auditoría 

Seguridad 

38 

Gestión de alertas operativas 

Utilidad 

Desacopla monitoreo e incidencias del flujo principal. 

Evento 

Alerta 

TMS 

39 

Programación de ventanas de entrega 

Tarea 

Autonomía: Gestiona horarios de entrega y disponibilidad de recepción. 

Pedido 

Horario asignado 

Logística 

40 

Cierre pedido ERP 

Integración 

Bajo acoplamiento: ERP se actualiza sin afectar otros sistemas. 

Pedido 

Cerrado 

ERP 

 

Interfaces, contrato e implementación 

Svc_ValidarStock 

Contrato 

Recibe identificador del producto 

Recibe cantidad solicitada 

Valida que el producto exista 

Consulta el stock disponible en el sistema 

Verifica si la cantidad solicitada puede ser atendida 

Retorna disponibilidad del producto 

Devuelve información en formato estructurado (JSON) 

 

Interfaces 

validacion_stock(id_producto, cantidad) 

 

Implementación 

Valida datos de entrada (id_producto, cantidad) 

Consulta a base de datos por el id del producto 

Consulta tabla de inventario 

Obtiene el stock actual del producto 

Compara stock disponible con cantidad solicitada 

Determina si hay disponibilidad (true/false) 

Respuesta en formato JSON: 

{ 

  disponible: true, 

  stock_actual: 120 

} 

 

Svc_CalcularRutaEntrega 

Contrato 

Recibe dirección de origen (almacén) 

Recibe dirección de destino (cliente) 

Recibe datos del pedido (peso, volumen) 

Consulta servicio de geolocalización 

Evalúa condiciones de tráfico 

Calcula la mejor ruta disponible 

Determina tiempo estimado de entrega 

Responde la información en un formato establecido 

 

Interfaces 

calcular_ruta_entrega(origen, destino, peso, volumen) 

 

Implementación 

Valida datos de entrada (origen, destino, peso, volumen) 

Llama a servicio de geolocalización (API externa) 

Obtiene coordenadas geográficas 

Consulta servicio de tráfico en tiempo real 

Evalúa múltiples rutas disponibles 

Calcula distancia y tiempo estimado 

Selecciona la mejor ruta (optimización) 

Genera tiempo estimado de entrega 

Manejo asincrónico: 

Procesa la solicitud en segundo plano (cola de procesos) 

Integraciones: 

Servicio externo de mapas (Google Maps API o similar) 

Respuesta en formato JSON: 

{ 

  ruta: "Ruta óptima por Av. Panamericana Sur", 

  distancia_km: 25, 

  tiempo_estimado_min: 40 

} 

 

Svc_NotificarDespacho 

Contrato 

Recibe identificador del pedido 

Recibe datos del cliente (contacto) 

Recibe estado del despacho 

Consulta información del pedido en el sistema 

Genera mensaje de notificación 

Envía notificación al cliente (SMS, correo o push) 

Responde el estado del envío de notificación en un formato establecido 

 

Interfaces 

notificar_despacho(id_pedido, cliente, estado) 

 

Implementación 

Valida datos de entrada (id_pedido, cliente, estado) 

Consulta tabla de pedidos 

Obtiene información del despacho 

Genera mensaje personalizado para el cliente 

Llama a servicio externo de mensajería (SMS, correo o push) 

Envía la notificación al cliente 

Registra el envío en la base de datos 

Integraciones: 

Servicio externo de notificaciones (API SMS / Email) 

Seguridad: 

Validación de acceso mediante token 

No almacena estado de sesión (stateless) 

Respuesta en formato JSON: 

{  

  enviado: true,  

  mensaje: "Notificación enviada correctamente"  

} 

 

 

Svc_RegistrarFirmaDigital 

Contrato 

Recibe identificador del pedido 

Recibe datos del cliente 

Recibe firma digital (imagen o hash) 

Valida la autenticidad de la firma 

Encripta la firma digital 

Registra la firma asociada al pedido 

Almacena evidencia de la entrega 

Permite auditoría del proceso 

Responde la confirmación en un formato establecido 

 

Interfaces 

registrar_firma_digital(id_pedido, cliente, firma) 

 

Implementación 

Valida datos de entrada (id_pedido, cliente, firma) 

Consulta tabla de pedidos 

Verifica que el pedido esté en estado "entregado" 

Valida formato de firma (imagen o hash) 

Encripta la firma digital (algoritmo SHA-256 o similar) 

Almacena la firma en la base de datos 

Registra fecha y hora de la transacción 

Genera registro de auditoría 

Integraciones: 

Sistema de gestión documental o repositorio de evidencias 

Seguridad: 

Aplicación de modelo Zero Trust 

Validación de identidad del usuario 

Uso de token de autenticación 

Protección de datos sensibles 

Respuesta en formato JSON: 

{  

  registrado: true,  

  mensaje: "Firma digital registrada correctamente"  

} 

 

Agrupación de procesos a servicio 

Siguiendo el modelo de Capas de SOA, organizamos los servicios para garantizar escalabilidad y alineación con los objetivos estratégicos de Lindley. 

Capa de Servicios de Orquestación (Procesos):  

Coordina el flujo lógico desde la salida de la planta de Pucusana hasta el cliente final, gestionando la secuencia de ejecución de los servicios inferiores. 

Capa de Servicios de Negocio (Tarea/Entidad): 

Gestión de Inventario: Agrupa Svc_ValidarStock y actualización de mermas. 

Gestión de Distribución: Agrupa Svc_CalcularRutaEntrega y asignación de transportista. 

Capa de Servicios de Aplicación (Infraestructura): 

Notificaciones: Agrupa Svc_NotificarDespacho para disponibilidad global de la empresa. 

Seguridad y Auditoría: Agrupa Svc_RegistrarFirmaDigital para asegurar la integridad transaccional. 

Modelo de seguridad 

5.1 Enfoque General de Seguridad 

El sistema de Gestión de Pedidos y Distribución adopta un enfoque de seguridad basado en el modelo Zero Trust, el cual establece que ningún usuario, dispositivo o servicio es confiable por defecto. En este contexto, cada acceso al sistema, ya sea para registrar pedidos, consultar stock o gestionar despachos, debe ser validado de forma continua. 

5.2 Principios Fundamentales de Seguridad 

5.2.1 Confidencialidad e Integridad de la Información 

Los datos relacionados con clientes, pedidos, inventario y pagos son protegidos mediante mecanismos de cifrado tanto en almacenamiento como en transmisión. Asimismo, se implementan controles que evitan la alteración no autorizada de la información. 

5.2.2 Control de Accesos 

El sistema utiliza un modelo de control basado en roles (RBAC), donde cada usuario (vendedor, almacén, administrador) accede únicamente a los módulos necesarios. Además, se emplea autenticación multifactor (MFA) para reforzar la seguridad. 

5.2.3 Protección ante Accesos No Autorizados 

El sistema incorpora mecanismos de supervisión y validación constante que permiten identificar y mitigar intentos de acceso indebido, fortaleciendo así la protección general del entorno. 

5.3 Seguridad frente a Amenazas y Ataques 

5.3.1 Inyección SQL (SQL Injection) 

Se previene mediante validación de entradas y uso de consultas parametrizadas en servicios como registro de pedidos y gestión de clientes. 

5.3.2 Ataques de Denegación de Servicio (DoS) 

Se implementan mecanismos como limitación de solicitudes y monitoreo de tráfico para evitar la saturación del sistema, especialmente en servicios críticos como pedidos y consultas. 

5.3.3 Ataques de Repetición (Replay Attack) 

Se utilizan tokens con tiempo de expiración para evitar la reutilización de solicitudes en procesos como autenticación y transacciones. 

5.5 Monitoreo y Auditoría 

Se implementa un sistema de monitoreo que registra: 

 

Accesos de usuarios 

Operaciones realizadas 

Cambios en pedidos y stock 

 

Esto permite detectar anomalías y realizar auditorías periódicas. 

5.6 Aplicación del Modelo Zero Trust 

El modelo Zero Trust se aplica en todos los servicios del sistema: 

 

Cada solicitud es validada antes de ser procesada 

No se confía en accesos internos automáticamente 

Se verifica constantemente la identidad del usuario 

 

Esto reduce riesgos en procesos críticos como distribución y facturación. 

 

6.1 Introducción 

 

En el sistema de Gestión de Pedidos y Distribución de Arca Continental Lindley, los roles dentro de la arquitectura SOA permiten garantizar el adecuado diseño, implementación, seguridad y control de los servicios que soportan el proceso logístico, desde la preparación del pedido en almacén hasta la entrega al cliente final. 

Diseño de disciplina 

Elemento de Diseño 

Decisión Tomada 

Justificación 

Identificación de Servicios 

Se definieron 10 servicios independientes para cubrir el ciclo completo de gestión de pedidos y distribución. 

Permite separar responsabilidades y facilitar la reutilización. 

Diseño de Contratos 

Cada servicio expone una interfaz REST con contratos bien definidos de entrada y salida. 

Garantiza interoperabilidad entre consumidores y proveedores. 

Diseño de Mensajes 

Se utilizó JSON como formato estándar para requests y responses. 

Facilita la integración entre sistemas heterogéneos y reduce complejidad. 

Diseño de Interfaces 

Se implementaron endpoints HTTP independientes para cada servicio. 

Favorece el bajo acoplamiento y la autonomía de los servicios. 

Reutilización de Servicios 

Servicios como Validar Stock, Notificar Cliente y Consultar Estado pueden ser utilizados por distintos procesos. 

Cumple el principio de reutilización de SOA. 

Autonomía de Servicios 

Cada servicio ejecuta una función específica sin depender de la lógica interna de otros servicios. 

Facilita mantenimiento y escalabilidad. 

Estandarización 

Todos los servicios utilizan la misma estructura de mensajes y respuestas. 

Mejora la gobernanza y consistencia de la plataforma. 

Manejo de Errores 

Se definió un servicio transversal para gestionar excepciones y errores. 

Permite respuestas uniformes y trazabilidad. 

Seguridad 

Se contempla validación mediante JWT y control de acceso RBAC. 

Protege los servicios y garantiza acceso autorizado. 

Trazabilidad 

Se utilizan componentes Logger en todos los flujos MuleSoft. 

Facilita monitoreo, auditoría y diagnóstico de incidentes. 

 

6.2 Roles Definidos 

6.2.1 Analista de Servicios 

 

Identifica y define los servicios necesarios a partir del proceso modelado en Bizagi, como validación de inventario, generación de picking, optimización de rutas y gestión de entregas. Se encarga de traducir los requerimientos del negocio logístico en especificaciones funcionales que puedan ser implementadas como servicios reutilizables. 

 

6.2.2 Arquitecto de Servicios 

 

Diseña la arquitectura del sistema organizando los servicios en capas (orquestación, negocio y aplicación), asegurando la correcta integración entre sistemas como ERP, WMS y TMS. Define la interacción entre servicios como preparación de pedidos, distribución logística, notificación al cliente y cierre del pedido. 

 

6.2.3 Especialista en Seguridad 

 

Implementa mecanismos de seguridad en los servicios del sistema, aplicando modelos como Zero Trust, autenticación mediante tokens (JWT) y control de accesos basado en roles (RBAC). Protege procesos críticos como cobranza, firma digital y generación de documentos electrónicos. 

 

6.2.4 Especialista en QA (Quality Assurance) 

 

Evalúa el correcto funcionamiento de los servicios mediante pruebas funcionales y de rendimiento. Verifica procesos como validación de stock, cálculo de rutas, entrega de pedidos y registro de incidencias, asegurando la calidad y confiabilidad del sistema. 

 

6.2.5 Especialista en Gobernanza 

 

Define políticas y estándares para la gestión de servicios dentro de la organización. Supervisa el versionamiento, reutilización y cumplimiento de buenas prácticas en servicios como inventario, transporte y notificaciones, evitando redundancias y asegurando consistencia en la arquitectura. 

 

6.2.6 Custodio de Estándares de Diseño 

 

Establece lineamientos técnicos para el desarrollo de servicios, como nomenclatura, estructura de APIs y formatos de intercambio de datos (JSON/XML). Garantiza que todos los servicios del sistema sigan un diseño uniforme y escalable. 

 

6.2.7 Custodio del Schema 

 

Define y mantiene las estructuras de datos utilizadas por los servicios, como los esquemas de pedidos, clientes, inventario y entregas. Asegura la consistencia de la información entre los sistemas ERP, WMS y TMS. 

 

6.2.8 Custodio de Políticas 

 

Gestiona las políticas de acceso, seguridad y uso de los servicios. Define reglas como autenticación obligatoria, control de permisos y restricciones de acceso para servicios críticos del sistema. 

 

6.2.9 Especialista Técnico en Comunicaciones 

 

Se encarga de la integración entre sistemas mediante APIs y servicios web, asegurando la correcta comunicación entre ERP, WMS, TMS y servicios externos como SUNAT o plataformas de notificación. 

 

6.2.10 Agente de Servicio 

 

Actúa como intermediario entre los usuarios (clientes, vendedores, operadores logísticos) y los servicios del sistema. Permite el acceso a funcionalidades como consulta de pedidos, seguimiento de entregas y notificaciones, pudiendo ser expuesto como API Gateway o interfaz de acceso. 

 

7.1 Interface: Creación de Pedido 

 

Nombre del Flow 

 

• Flow_Crear_Pedido 

 

Endpoint 

 

• /api/pedido/crear 

 

URL Localhost 

 

• http://localhost:8081/api/pedido/crear 

 

Método HTTP 

 

• POST 

 

Objetivo 

 

• Registrar pedidos en el sistema ERP logístico antes del cierre de pedido. 

 

Descripción del proceso 

 

El flujo recibe la información del pedido y registra la creación del mismo en el sistema. 

 

Componentes utilizados 

 

• HTTP Listener 

• Logger 

• Transform Message 

 

Entrada esperada 

{ 

  "pedido": "PED001", 

  "cliente": "Lindley" 

} 

 

Salida esperada 

{ 

  "pedido": "PED001", 

  "estado": "Creado", 

  "cliente": "Lindley" 

} 

 

Captura de ejecución 

Diagrama

Descripción generada automáticamente 

Texto

Descripción generada automáticamente 

7.2 Interface: Validación de Stock 

 

Nombre del Flow 

 

• Flow_Validar_Stock 

 

Endpoint 

 

• /api/inventario/validar 

 

URL Localhost 

 

• http://localhost:8081/api/inventario/validar 

 

Método HTTP 

 

• GET 

 

Objetivo 

 

• Validar disponibilidad de stock antes del despacho. 

 

Descripción del proceso 

 

El flujo consulta la disponibilidad del producto solicitado y devuelve el stock disponible. 

 

Componentes utilizados 

 

• HTTP Listener 

• Logger 

• Transform Message 

 

Entrada esperada 

{ 

  "producto": "P100" 

} 

 

 

Salida esperada 

{ 

  "disponible": true, 

  "stock_actual": 120, 

  "producto": "P100" 

} 

 

Captura de ejecución 

Diagrama

Descripción generada automáticamente 

 

Interfaz de usuario gráfica, Texto, Aplicación

Descripción generada automáticamente 

7.3 Interface: Optimización de Ruta 

 

Nombre del Flow 

 

• Flow_Optimizar_Ruta 

 

Endpoint 

 

• /api/ruta/optimizar 

 

URL Localhost 

 

• http://localhost:8081/api/ruta/optimizar 

 

Método HTTP 

 

• POST 

 

Objetivo 

 

• Optimizar rutas logísticas para distribución de pedidos. 

 

Descripción del proceso 

 

El flujo procesa la información del destino y devuelve la mejor ruta disponible. 

 

Componentes utilizados 

 

• HTTP Listener 

• Logger 

• Transform Message 

 

Entrada esperada 

{ 

  "destino": "Lima Norte" 

} 

 

Salida esperada 

{ 

  "ruta": "Ruta Lima Norte", 

  "tiempo_estimado": "45 min", 

  "estado": "Optimizada" 

} 

 

 

Captura de ejecución 

Diagrama

Descripción generada automáticamente 

 

Interfaz de usuario gráfica, Texto, Aplicación

Descripción generada automáticamente 

 

 

7.4 Interface: Generación de Guía SUNAT 

 

Nombre del Flow 

 

• Flow_Guia_SUNAT 

 

Endpoint 

 

• /api/sunat/guia 

 

URL Localhost 

 

• http://localhost:8081/api/sunat/guia 

 

Método HTTP 

 

• POST 

 

Objetivo 

 

• Generar guía electrónica para traslado de productos. 

 

Descripción del proceso 

 

El flujo procesa la solicitud y genera una guía electrónica para SUNAT. 

 

Componentes utilizados 

 

• HTTP Listener 

• Logger 

• Transform Message 

 

Entrada esperada 

{ 

  "pedido": "PED001" 

} 

 

Salida esperada 

{ 

  "guia": "T001-4587", 

  "estado": "Generada", 

  "sunat": true 

} 

 

Captura de ejecución 

 

 

Interfaz de usuario gráfica, Texto, Aplicación, Correo electrónico

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

 

7.5 Interface: Notificación al Cliente 

Nombre del Flow 

• Flow_Notificacion_Cliente 

Endpoint 

• /api/notificacion/cliente 

URL Localhost 

• http://localhost:8081/api/notificacion/cliente 

Método HTTP 

• POST 

Objetivo 

• Enviar notificaciones automáticas sobre el estado del pedido. 

Descripción del proceso 

El flujo recibe información del pedido y envía una notificación al cliente. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "cliente": "Lindley", 

  "pedido": "PED001" 

} 

Salida esperada 

{ 

  "cliente": "Lindley", 

  "mensaje": "Pedido en camino", 

  "estado": "Enviado" 

} 

Captura de ejecución 

Texto

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

7.6 Interface: Registro de Entrega 

Nombre del Flow 

• Flow_Registro_Entrega 

Endpoint 

• /api/entrega/registrar 

URL Localhost 

• http://localhost:8081/api/entrega/registrar 

Método HTTP 

• POST 

Objetivo 

• Registrar la entrega final del pedido al cliente. 

Descripción del proceso 

El flujo registra la confirmación de entrega y devuelve el estado actualizado del pedido. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "pedido": "PED001" 

} 

Salida esperada 

{ 

  "pedido": "PED001", 

  "estado": "Entregado", 

  "hora": "18:30" 

} 

Captura de ejecución 

Texto

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

 

 

7.7 Interface: Firma Digital POD 

Nombre del Flow 

• Flow_Firma_Digital 

Endpoint 

• /api/pod/firma 

URL Localhost 

• http://localhost:8081/api/pod/firma 

Método HTTP 

• POST 

Objetivo 

• Registrar la firma digital como prueba de entrega. 

Descripción del proceso 

El flujo procesa la firma digital del cliente y devuelve la confirmación del proceso. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "cliente": "Metro" 

} 

Salida esperada 

{ 

  "firma": true, 

  "cliente": "Metro", 

  "estado": "Confirmado" 

} 

Captura de ejecución 

Texto

Descripción generada automáticamente 

Diagrama

Descripción generada automáticamente 

 

7.8 Interface: Registro de Incidencias 

Nombre del Flow 

• Flow_Registro_Incidencia 

Endpoint 

• /api/incidencia/registrar 

URL Localhost 

• http://localhost:8081/api/incidencia/registrar 

Método HTTP 

• POST 

Objetivo 

• Registrar incidencias ocurridas durante el proceso logístico. 

Descripción del proceso 

El flujo recibe la incidencia reportada y devuelve la confirmación del registro. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "incidencia": "Carga dañada" 

} 

Salida esperada 

{ 

  "incidencia": "Carga dañada", 

  "estado": "Registrada" 

} 

Captura de ejecución 

Texto

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

7.9 Interface: Consulta de Pedido 

Nombre del Flow 

• Flow_Consulta_Pedido 

Endpoint 

• /api/pedido/consulta 

URL Localhost 

• http://localhost:8081/api/pedido/consulta 

Método HTTP 

• GET 

Objetivo 

• Consultar el estado actual de los pedidos registrados. 

Descripción del proceso 

El flujo procesa la consulta del pedido y devuelve información del estado logístico. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "pedido": "PED001" 

} 

Salida esperada 

{ 

  "pedido": "PED001", 

  "estado": "En ruta", 

  "transportista": "Juan Perez" 

} 

Captura de ejecución 

Texto

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

7.10 Interface: Manejo de Error Global 

Nombre del Flow 

• Flow_Manejo_Error 

Endpoint 

• /api/error/global 

URL Localhost 

• http://localhost:8081/api/error/global 

Método HTTP 

• GET 

Objetivo 

• Gestionar errores generales del sistema de integración SOA. 

Descripción del proceso 

El flujo devuelve un mensaje de error controlado para validar el manejo de excepciones. 

Componentes utilizados 

• HTTP Listener 
• Logger 
• Transform Message 

Entrada esperada 

{ 

  "error": true 

} 

Salida esperada 

{ 

  "error": true, 

  "mensaje": "Ocurrio un error" 

} 

Captura de ejecución 

 

Texto

Descripción generada automáticamente 

 

Diagrama

Descripción generada automáticamente 

 

 

 

 

8. Diseño de mensajes 

Para garantizar la interoperabilidad, el bajo acoplamiento y la estandarización del diseño, todos los servicios de la arquitectura de la Gestión de Pedidos y Distribución utilizarán el formato JSON para el intercambio de datos.  

 

 

8.1 Estructura de mensajes (JSON request/response) 

Las solicitudes (Requests) y respuestas (Responses) se estructuran de forma homogénea. El cuerpo de los mensajes se divide en un bloque de metadatos de control (identificadores, marcas de tiempo) y el bloque de datos específicos del negocio. 

 

Ejemplo: Solicitud de Optimización de Ruta (Svc_CalcularRutaEntrega)  

 

 

 
 

 

 

8.2 Mensajes de respuesta exitosa 

Toda respuesta exitosa procesada por la plataforma de servicios devolverá un código de estado HTTP 200 OK (o 201 Created para registros) y un objeto estandarizado que confirma el éxito de la operación junto con la carga útil (payload) requerida.  

 

Ejemplo: Respuesta exitosa de Optimización de Ruta  

 

 

 

 

 

 

 

 

 

8.3 Mensajes de error 

Cuando una solicitud no puede ser procesada (por fallas de validación, negocio o infraestructura), el servicio responderá con el código HTTP correspondiente (4xx o 5xx) y un esquema de error unificado que facilita el diagnóstico por parte del Especialista en QA y el Agente de Servicio.  

 

Ejemplo: Error por Validación de Stock Insuficiente (Svc_ValidarStock)  

 

 

 

 

8.4 Validaciones de datos 

El Custodio de Estándares de Diseño y el Custodio del Schema definen que cada servicio debe ejecutar tres niveles de validación antes de procesar la lógica de negocio:  

 

Validación Estructural (Sintáctica): Verifica que el mensaje sea válido y que cumpla estrictamente con el esquema (Schema) del contrato (campos obligatorios, tipos de datos como string, integer, float).  

Validación de Seguridad: Ejecutada por la capa intermedia (API Gateway) bajo el modelo Zero Trust. Comprueba la vigencia y firma del token de acceso (JWT), la expiración del token (prevención de Replay Attacks) y los permisos del rol del usuario mediante RBAC.  

Validación Semántica (Reglas de Negocio): Evalúa la coherencia de los datos en base al estado actual del sistema (ej. verificar que un pedido esté en estado "entregado" antes de permitir registrar la firma digital, o que los pesos no superen la capacidad física del camión asignado). 

8.4.1 Descripcion de funcionalidades 

Svc_CrearPedido 

Atributo 

Descripción 

Nombre del Servicio 

Svc_CrearPedido 

Tipo de Servicio 

Servicio de Negocio 

Dominio 

Gestión de Pedidos 

Descripción Funcional 

Permite registrar nuevos pedidos provenientes de clientes y generar una orden de distribución dentro de la plataforma logística. 

Capacidad del Servicio 

Creación y registro de pedidos. 

Consumidores 

Portal Comercial, ERP, Aplicación Móvil de Ventas 

Proveedor 

Plataforma de Gestión de Pedidos 

Operación Principal 

CrearPedido() 

Mensaje de Entrada 

Datos del cliente, productos, cantidades, dirección de entrega. 

Mensaje de Salida 

Código de pedido, estado de creación, fecha de registro. 

Dependencias 

Svc_ValidarStock 

Política de Seguridad 

Autenticación JWT y autorización RBAC. 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

Solo se registran pedidos con información completa y válida. 

Excepciones 

Cliente inexistente, datos incompletos, productos inválidos. 

Nivel de Reutilización 

Alto 

Estado del Servicio 

Activo 

 

Svc_ValidarStock 

Atributo 

Descripción 

Nombre del Servicio 

Svc_ValidarStock 

Tipo de Servicio 

Servicio de Entidad 

Dominio 

Inventario 

Descripción Funcional 

Consulta y valida la disponibilidad de productos solicitados antes de autorizar el procesamiento del pedido. 

Capacidad del Servicio 

Verificación de inventario. 

Consumidores 

Svc_CrearPedido, Svc_CalcularRutaEntrega 

Proveedor 

Sistema de Inventario 

Operación Principal 

ValidarStock() 

Mensaje de Entrada 

Código de producto, cantidad solicitada. 

Mensaje de Salida 

Estado de disponibilidad, stock actual. 

Dependencias 

Base de Datos de Inventario 

Política de Seguridad 

JWT + RBAC 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

La cantidad solicitada no debe superar el stock disponible. 

Excepciones 

Producto inexistente, inventario no disponible. 

Nivel de Reutilización 

Muy Alto 

Estado del Servicio 

Activo 

 

 

Svc_CalcularRutaEntrega 

Atributo 

Descripción 

Nombre del Servicio 

Svc_CalcularRutaEntrega 

Tipo de Servicio 

Servicio de Negocio 

Objetivo 

Optimizar la ruta de entrega de pedidos. 

Consumidor 

Gestión de Distribución 

Entradas 

Ubicación de origen y destino, restricciones logísticas. 

Salidas 

Ruta óptima, tiempo estimado. 

Regla de Negocio 

Debe seleccionarse la ruta de menor costo y tiempo posible. 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

Svc_CalcularRutaEntrega 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

Atributo 

Descripción 

Nombre del Servicio 

Svc_CalcularRutaEntrega 

Tipo de Servicio 

Servicio de Negocio 

Dominio 

Distribución 

Descripción Funcional 

Determina la ruta óptima para la entrega de pedidos considerando variables logísticas y operativas. 

Capacidad del Servicio 

Optimización de rutas de entrega. 

Consumidores 

Gestión de Distribución, Centro de Control Logístico 

Proveedor 

Motor de Optimización Logística 

Operación Principal 

CalcularRutaEntrega() 

Mensaje de Entrada 

Origen, destino, capacidad de transporte, restricciones logísticas. 

Mensaje de Salida 

Ruta óptima, tiempo estimado, distancia calculada. 

Dependencias 

Svc_ValidarStock, Sistema de Geolocalización 

Política de Seguridad 

JWT + RBAC 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

Debe seleccionarse la ruta con menor costo y tiempo de recorrido. 

Excepciones 

Dirección inválida, ruta no disponible. 

Nivel de Reutilización 

Alto 

Estado del Servicio 

Activo 

 

 

Svc_GenerarGuiaSUNAT 

Atributo 

Descripción 

Nombre del Servicio 

Svc_GenerarGuiaSUNAT 

Tipo de Servicio 

Servicio de Integración 

Dominio 

Cumplimiento Tributario 

Descripción Funcional 

Genera la guía de remisión electrónica requerida para el transporte de mercancías. 

Capacidad del Servicio 

Emisión de documentos electrónicos. 

Consumidores 

Gestión de Distribución 

Proveedor 

Plataforma de Integración Tributaria 

Operación Principal 

GenerarGuiaSUNAT() 

Mensaje de Entrada 

Datos del pedido, transportista y destino. 

Mensaje de Salida 

Número de guía, estado de emisión. 

Dependencias 

SUNAT, Svc_CrearPedido 

Política de Seguridad 

JWT + RBAC 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

Solo pueden emitirse guías para pedidos aprobados. 

Excepciones 

Error de validación tributaria, pedido no aprobado. 

Nivel de Reutilización 

Medio 

Estado del Servicio 

Activo 

 

 

 

 

Svc_NotificarCliente 

Atributo 

Descripción 

Nombre del Servicio 

Svc_NotificarCliente 

Tipo de Servicio 

Servicio de Aplicación 

Dominio 

Comunicación 

Descripción Funcional 

Envía notificaciones relacionadas con el estado del pedido. 

Capacidad del Servicio 

Gestión de comunicaciones con clientes. 

Consumidores 

Gestión de Distribución, Portal de Clientes 

Proveedor 

Plataforma de Notificaciones 

Operación Principal 

NotificarCliente() 

Mensaje de Entrada 

ID de pedido, mensaje, canal de comunicación. 

Mensaje de Salida 

Confirmación de envío. 

Dependencias 

Servicio de Correo, SMS o Push Notifications 

Política de Seguridad 

JWT + RBAC 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

Solo se notifican eventos válidos del ciclo de vida del pedido. 

Excepciones 

Canal no disponible, cliente no registrado. 

Nivel de Reutilización 

Alto 

Estado del Servicio 

Activo 

Svc_RegistrarEntrega 

Atributo 

Descripción 

Nombre del Servicio 

Svc_RegistrarEntrega 

Tipo de Servicio 

Servicio de Negocio 

Dominio 

Entregas 

Descripción Funcional 

Registra la entrega efectiva de un pedido al cliente final. 

Capacidad del Servicio 

Confirmación de entregas. 

Consumidores 

Aplicación del Transportista 

Proveedor 

Gestión de Entregas 

Operación Principal 

RegistrarEntrega() 

Mensaje de Entrada 

ID del pedido, fecha, hora y ubicación de entrega. 

Mensaje de Salida 

Confirmación de entrega. 

Dependencias 

Svc_CrearPedido 

Política de Seguridad 

JWT + RBAC 

Protocolo 

HTTP/REST 

Formato de Mensaje 

JSON 

Patrón de Intercambio 

Request-Response 

Regla de Negocio 

El pedido debe encontrarse en estado "En Ruta". 

Excepciones 

Pedido inexistente, entrega duplicada. 

Nivel de Reutilización 

Medio 

Estado del Servicio 

Activo 

8.5 Códigos de error del sistema sobre este proyecto 

Para centralizar las excepciones de la arquitectura del proyecto, se establece la siguiente matriz de códigos de error unificados: 

 

 

9. Contratos de servicios  

En esta sección describimos los contratos de cada servicio del flujo para la empresa: 

Nombre del Servicio 

Descripción del Servicio 

Protocolo de comunicación 

Puertos 

Operaciones pertenecientes al servicio (Por cada Operación del servicio, su endpoint, parametros de entrada, parametros de salida, respuesta exitosa, posibles errores.) 

Parametros (Tipos, Obligatoriedad, Descripción) 

 

Sincronización ERP–WMS 

 

 

Planificación de oleadas 

 

Generación de picking 

 

Ejecución de picking 

 

Control de calidad 

 

Consolidación y estibado 

 

Etiquetado LPN 

 

Validación de inventario 

 

Asignación de bahía 

 

Validación de transportista 

 

Carga de mercancía 

 

Escaneo de carga 

 

Corrección de carga 

 

Generación de guía 

 

Optimización de rutas 

 

Activación GPS 

 

Geocercas 

 

Registro de incidencias 

 

Re-ruteo dinámico 

 

Notificación cliente 

 

Descarga de productos 

 

Validación vs factura 

 

Gestión retornables 

 

Cobranza 

 

Firma digital (POD) 

 

Recepción cliente 

 

Retorno a CD 

 

Liquidación 

 

Validación de cliente 

 

Consulta de estado de pedido 

 

Gestión de devoluciones 

 

Actualización de stock automático 

 

Validación de documentos de transporte 

 

Validación de capacidad vehicular 

 

Monitoreo de temperatura de carga 

 

Gestión de mantenimiento vehicular 

 

Auditoría de transacciones 

 

Gestión de alertas operativas 

 

Programación de ventanas de entrega 

 

Cierre pedido ERP 

 

 

  

10. Inventario de servicios  

 

En esta sección se consolida el catálogo de los 40 servicios identificados para el proceso de Gestión de Pedidos y Distribución de Arca Continental Lindley S.A., diseñados bajo los principios de Arquitectura Orientada a Servicios (SOA) para garantizar bajo acoplamiento, escalabilidad y reutilización. 

 

10.1 Lista de servicios del proceso 

 

A continuación, se detalla el inventario completo de los 40 servicios que soportan la operación logística, organizados por su dominio de acción:  

ID 

Nombre del Servicio 

Sistema Origen 

1-8 

Sincronización ERP-WMS, Planificación de oleadas, Generación/Ejecución de picking, Control de calidad, Consolidación y estibado, Etiquetado LPN, Validación de inventario 

ERP / WMS 

9-14 

Asignación de bahía, Validación de transportista, Carga de mercancía, Escaneo de carga, Corrección de carga, Generación de guía SUNAT 

Logística / SUNAT 

15-19 

Optimización de rutas, Activación GPS, Geocercas, Registro de incidencias, Re-ruteo dinámico 

TMS 

20-26 

Notificación cliente, Descarga de productos, Validación vs factura, Gestión retornables, Cobranza, Firma digital (POD), Recepción cliente 

App / Cliente / Repartidor 

27-28 

Retorno a CD, Liquidación 

Logística / Admin 

29-32 

Validación de cliente, Consulta de estado de pedido, Gestión de devoluciones, Actualización de stock automático 

ERP / WMS / Logística 

33-36 

Validación de documentos de transporte, Validación de capacidad vehicular, Monitoreo de temperatura de carga, Gestión de mantenimiento vehicular 

Logística / TMS / Flota 

37-40 

Auditoría de transacciones, Gestión de alertas operativas, Programación de ventanas de entrega, Cierre pedido ERP 

Seguridad / TMS / Logística / ERP 

 

10.2 Clasificación de servicios: 

 Siguiendo el estándar SOA, los 40 servicios se agrupan en cuatro categorías principales según su función y nivel de abstracción:  

 

A. Servicios de Integración (Integration Services) 

Encargados exclusivamente de la interoperabilidad técnica y la sincronización de datos entre los distintos sistemas heterogéneos 

1. Sincronización ERP–WMS  

14. Generación de guía  

32. Actualización de stock automático  

40. Cierre pedido ERP 

 

B. Servicios Reutilizables (Utility / Shared Entity Services) Servicios diseñados con un enfoque "stateless" (sin estado) y de alta encapsulación. Poseen un alto grado de reusabilidad, ya que pueden ser consumidos concurrentemente por el flujo de despacho, así como por otros procesos de la empresa (ventas, atención al cliente, logística inversa).  

 

7. Etiquetado LPN  

8. Validación de inventario  

16. Activación GPS  

17. Geocercas  

20. Notificación cliente  

23. Gestión retornables  

25. Firma digital (POD)  

29. Validación de cliente  

30. Consulta de estado de pedido  

35. Monitoreo de temperatura de carga  

36. Gestión de mantenimiento vehicular  

37. Auditoría de transacciones  

38. Gestión de alertas operativas 

 

C. Servicios de Negocio (Business Services) Representan las tareas y entidades lógicas que sostienen el núcleo del negocio logístico (Core Business). Encapsulan reglas complejas que son fundamentales para la correcta distribución de los productos. 16. Planificación de oleadas  

 

2. Planificación de oleadas  

3. Generación de picking  

5. Control de calidad  

15. Optimización de rutas  

18. Registro de incidencias  

19. Re-ruteo dinámico  

24. Cobranza  

28. Liquidación  

31. Gestión de devoluciones  

33. Validación de documentos de transporte  

39. Programación de ventanas de entrega 

 

D. Servicios de Aplicación (Application / Task Services) Representan acciones operativas muy específicas ligadas a la interfaz de usuario, interacción humana o interacciones directas con la mercancía física. Suelen orquestar tareas transaccionales puntuales dentro de una aplicación particular (como la App del conductor o la terminal del operario).  

 

4. Ejecución de picking  

6. Consolidación y estibado  

9. Asignación de bahía  

10. Validación de transportista  

11. Carga de mercancía  

12. Escaneo de carga  

13. Corrección de carga  

21. Descarga de productos  

22. Validación vs factura  

26. Recepción cliente  

27. Retorno a CD  

34. Validación de capacidad vehicular 

  

10.3 Relación con el proceso Bizagi 

 

FASE 1: Preparación de Pedidos (WMS & Almacén) 

Esta fase inicia en el sistema central y termina cuando el pallet está listo en la puerta del almacén. 

El disparador: El ERP recibe el pedido comercial y ejecuta la Sincronización ERP–WMS [Servicio 1] y la Validación de inventario [Servicio 8] para asegurar que haya producto. 

Operación WMS: El sistema de almacén agrupa los pedidos usando la Planificación de oleadas [Servicio 2], y crea las rutas de recolección interna con la Generación de picking [Servicio 3]. 

Física a Digital: Los operarios realizan la Ejecución de picking [Servicio 4] y pasan por el Control de calidad [Servicio 5]. 

Cierre de fase: Los productos se agrupan mediante la Consolidación y estibado [Servicio 6] y el pallet queda listo tras asignársele un Etiquetado LPN [Servicio 7] que lo identificará en todo el resto de la cadena. 

 

FASE 2: Carga de Transporte (Logística de Salida) 

Aquí la responsabilidad pasa del almacén (WMS) a logística de transporte. 

Asignación de recursos: El sistema realiza la Asignación de bahía [Servicio 9] para que el camión se estacione. Paralelamente, se ejecuta la Validación de transportista [Servicio 10] (documentos en regla del chofer) y la Validación de capacidad vehicular [Servicio 34] (asegurar que el peso/volumen del pallet no exceda al camión). 

Carga física: Mientras el montacargas hace la Carga de mercancía [Servicio 11], se realiza un Escaneo de carga [Servicio 12] para evitar faltantes. Si hay discrepancias, salta la Corrección de carga [Servicio 13]. 

Cumplimiento Legal: Antes de que el camión pise la calle, los sistemas orquestan la Validación de documentos de transporte [Servicio 33] y, obligatoriamente, la Generación de guía (SUNAT) [Servicio 14] para cumplir con la facturación electrónica peruana. 

 

FASE 3: Distribución Logística (TMS & Tracking) 

Esta fase representa el trayecto del camión por la ciudad, controlada enteramente por el TMS (Transport Management System). 

Enrutamiento: Antes de salir, se ejecuta la Optimización de rutas [Servicio 15] y la Programación de ventanas de entrega [Servicio 39] para cumplir con los horarios de los clientes (ej. bodegas o supermercados). 

Telemetría en tiempo real: Durante todo el viaje, están encendidos los servicios utilitarios: Activación GPS [Servicio 16], Geocercas [Servicio 17] y el Monitoreo de temperatura de carga [Servicio 35] (crítico para las bebidas). 

Gestión de crisis: Si hay tráfico pesado o un choque, se dispara el Registro de incidencias [Servicio 18] y la Gestión de alertas operativas [Servicio 38], lo que obliga al sistema a calcular un Re-ruteo dinámico [Servicio 19] para salvar la entrega. 

 

FASE 4: Entrega al Cliente (Punto de Venta) 

El momento de la verdad en la puerta del cliente (bodeguero o supermercado). 

Contacto inicial: El cliente recibe una Notificación cliente [Servicio 20] de que el camión está afuera. El chofer usa su App para la Validación de cliente [Servicio 29]. 

Descarga y conciliación: Se realiza la Descarga de productos [Servicio 21] y la inmediata Validación vs factura [Servicio 22] junto con la Recepción cliente [Servicio 26]. 

Logística inversa y pagos: El chofer recoge envases vacíos activando la Gestión retornables [Servicio 23] y efectúa la Cobranza [Servicio 24]. 

Cierre de fase: Todo queda registrado con valor legal a través del servicio de Firma digital (POD) [Servicio 25]. 

 

FASE 5: Liquidación y Cierre (Administrativo) 

El proceso final cuando el camión vuelve a la base (Planta Pucusana u otro CD). 

Llegada: Se marca el Retorno a CD [Servicio 27] y se evalúa si el camión necesita ir a taller mediante la Gestión de mantenimiento vehicular [Servicio 36]. 

Cuadre de caja y almacén: El área administrativa ejecuta la Liquidación [Servicio 28] (dinero y guías). Si hubo producto rechazado, entra a tallar la Gestión de devoluciones [Servicio 31] acoplada a una Actualización de stock automático [Servicio 32] para devolver esos productos al inventario virtual. 

Cierre del ciclo: Por debajo de todo esto, la Auditoría de transacciones [Servicio 37] graba los logs de seguridad, y finalmente, el ciclo muere con el Cierre pedido ERP [Servicio 40], dejando todo cuadrado en SAP. 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

 

10.4 Agrupación en Composite Application 

 

Gestión Logística 

Composite Application: Comp_DespachoYDistribución 

 

 

10.5 Identificación de Reusable Business Services 

 

Código de Servicio 

Nombre del Servicio 

Tipo de Servicio SOA 

Capacidad de Negocio Encapsulada 

Consumidores Potenciales Alternos 

Svc_ValidarStock 

Servicio de Consulta de Inventario Disponible 

Entity Service 

Consulta en tiempo real las existencias físicas y el stock comprometido en los centros de distribución (CEDIS). 

Portal B2B de clientes, Aplicación móvil de preventistas (Televentas), Canal E-commerce. 

Svc_GenerarGuia 

Servicio de Emisión de Guías de Remisión 

Utility Service 

Orquesta la comunicación fiscal con la SUNAT para la validación y firma digital de guías de remisión electrónicas de bienes. 

Proceso de traslados internos entre plantas, Proceso de devoluciones de mercancía a proveedores. 

Svc_Cobranza 

Servicio de Procesamiento de Pagos 

Entity Service 

Registra los ingresos monetarios, validando transacciones en efectivo, transferencias o pasarelas de pago digitales. 

Caja central, Módulo de recaudación de autoservicios, Portal de atención a reclamos. 

Svc_ValidarFactura 

Servicio de Verificación Fiscal de Comprobantes 

Utility Service 

Consulta el estado transaccional de los comprobantes electrónicos de pago emitidos previamente en el ERP. 

Área de contabilidad corporativa, Auditoría interna de finanzas, Portal de proveedores. 

Svc_CierrePedidoERP 

Servicio de Actualización de Ciclo de Vida del Pedido 

Entity Service 

Modifica el estado final de una orden en el núcleo transaccional (SAP ERP) y libera los saldos contables correspondientes 

Mesa de ayuda de atención al cliente (Call Center), Sistema de control de incidencias comerciales. 

 

 

10.6 Mapa general de servicios SOA 

 

 

  

10.7 Servicios web de los procesos 

 

Servicio 1. Sincronización ERP–WMS 

 

Código del Servicio: Svc_001 

 

Nombre del Servicio: Sincronización ERP–WMS 

 

Descripción: 

Permite sincronizar los pedidos registrados en el ERP con el WMS para iniciar el proceso de preparación de pedidos. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: SincronizarERPWMS 

 

Endpoint: 

 

https://soa.arcacontinental.com/services/ERPWMSService 

 

Sistema Consumidor: ERP SAP 

 

Sistema Proveedor: WMS 

 

Entradas 

IdPedido 

FechaPedido 

CodigoCliente 

Salidas 

Estado 

CodigoSincronizacion 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 2. Planificación de Oleadas 

 

Código del Servicio: Svc_002 

 

Descripción: 

Agrupa los pedidos pendientes para optimizar el proceso de picking según zonas, horarios y capacidad operativa. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: PlanificarOleadas 

 

Endpoint 

 

https://soa.arcacontinental.com/services/WavePlanningService 

 

Consumidor: WMS 

 

Proveedor: Motor de Planificación 

 

Entradas 

FechaDespacho 

CentroDistribucion 

ZonaEntrega 

Salidas 

IdOleada 

CantidadPedidos 

Estado 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 3. Generación de Picking 

 

Código del Servicio: Svc_003 

 

Descripción: 

Genera automáticamente las órdenes de picking para los operarios del almacén. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: GenerarPicking 

 

Endpoint 

 

https://soa.arcacontinental.com/services/PickingService 

 

Consumidor: WMS 

 

Proveedor: Módulo Picking 

 

Entradas 

IdOleada 

Salidas 

IdPicking 

Estado 

SOAP Request 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 4. Ejecución de Picking 

 

Código del Servicio: Svc_004 

 

Descripción: 

Registra la ejecución del picking por parte del operario y confirma los productos recolectados. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: EjecutarPicking 

 

Endpoint 

 

https://soa.arcacontinental.com/services/PickingExecutionService 

 

Consumidor: Terminal RF del Operario 

 

Proveedor: WMS 

 

Entradas 

IdPicking 

CodigoOperario 

HoraInicio 

Salidas 

Estado 

HoraFin 

TiempoProceso 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 5. Control de Calidad 

 

Código del Servicio: Svc_005 

 

Descripción: 

Verifica que los productos preparados cumplan con los estándares de calidad antes del despacho. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ControlCalidad 

 

Endpoint 

 

https://soa.arcacontinental.com/services/QualityControlService 

 

Consumidor: Área de Control de Calidad 

 

Proveedor: WMS 

 

Entradas 

IdPicking 

Inspector 

FechaInspeccion 

Salidas 

Resultado 

Observaciones 

Estado 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

Servicio 6. Consolidación y Estibado 

 

Código del Servicio: Svc_006 

 

Nombre del Servicio: Consolidación y Estibado 

 

Descripción: 

Agrupa los productos preparados en pallets y organiza la carga para optimizar el transporte y garantizar la estabilidad durante la distribución. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ConsolidarEstibado 

 

Endpoint 

 

https://soa.arcacontinental.com/services/PalletService 

 

Sistema Consumidor: WMS 

 

Sistema Proveedor: Módulo de Despacho 

 

Entradas 

IdPicking 

CodigoPallet 

Operario 

Salidas 

Estado 

CodigoLote 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response  

 

Texto

Descripción generada automáticamente 

 

 

Servicio 7. Etiquetado LPN 

 

Código del Servicio: Svc_007 

 

Descripción: 

Genera y asigna un código LPN (License Plate Number) único para identificar cada pallet durante toda la cadena logística. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: GenerarLPN 

 

Endpoint 

 

https://soa.arcacontinental.com/services/LPNService 

 

Sistema Consumidor: WMS 

 

Sistema Proveedor: Sistema de Etiquetado 

 

Entradas 

CodigoPallet 

CentroDistribucion 

Salidas 

CodigoLPN 

Estado 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 8. Validación de Inventario 

 

Código del Servicio: Svc_008 

 

Descripción: 

Verifica la disponibilidad de productos antes de iniciar la preparación del pedido. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ValidarInventario 

 

Endpoint 

 

https://soa.arcacontinental.com/services/InventoryService 

 

Sistema Consumidor: ERP SAP 

 

Sistema Proveedor: WMS 

 

Entradas 

CodigoProducto 

CantidadSolicitada 

Salidas 

Disponible 

StockDisponible 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 9. Asignación de Bahía 

 

Código del Servicio: Svc_009 

 

Descripción: 

Asigna automáticamente una bahía de carga disponible para el vehículo de reparto. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: AsignarBahia 

 

Endpoint 

 

https://soa.arcacontinental.com/services/DockAssignmentService 

 

Sistema Consumidor: WMS 

 

Sistema Proveedor: Sistema de Gestión Logística 

 

Entradas 

PlacaVehiculo 

CentroDistribucion 

Salidas 

NumeroBahia 

Estado 

HoraAsignacion 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 10. Validación de Transportista 

 

Código del Servicio: Svc_010 

 

Descripción: 

Valida que el conductor y el vehículo cumplan con los requisitos establecidos para realizar el transporte de mercancías. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ValidarTransportista 

 

Endpoint 

 

https://soa.arcacontinental.com/services/CarrierValidationService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Sistema de Gestión de Transporte 

 

Entradas 

DNI 

LicenciaConducir 

PlacaVehiculo 

Salidas 

EstadoValidacion 

Observaciones 

 

SOAP Request 

Texto

Descripción generada automáticamente 

 

SOAP Reponse 

 

Texto

Descripción generada automáticamente 

 

Servicio 11. Carga de Mercancía 

 

Código del Servicio: Svc_011 

 

Nombre del Servicio: Carga de Mercancía 

 

Descripción: 

Permite registrar la carga física de los pallets al vehículo de transporte, verificando que la mercancía corresponda al pedido programado. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: CargarMercancia 

 

Endpoint 

 

https://soa.arcacontinental.com/services/CargoLoadingService 

 

Sistema Consumidor: WMS 

 

Sistema Proveedor: TMS 

 

Entradas 

IdCarga 

CodigoPallet 

PlacaVehiculo 

Operario 

Salidas 

EstadoCarga 

HoraCarga 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

Servicio 12. Escaneo de Carga 

 

Código del Servicio: Svc_012 

 

Descripción: 

Escanea los códigos LPN antes de la salida del vehículo para validar que toda la carga corresponda al despacho. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: EscanearCarga 

 

Endpoint 

 

https://soa.arcacontinental.com/services/CargoScanningService 

 

Sistema Consumidor: Terminal RF 

 

Sistema Proveedor: WMS 

 

Entradas 

CodigoLPN 

IdCarga 

Salidas 

Resultado 

CantidadEscaneada 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 13. Corrección de Carga 

 

Código del Servicio: Svc_013 

 

Descripción: 

Permite registrar y corregir diferencias detectadas durante el escaneo de carga antes del despacho. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: CorregirCarga 

 

Endpoint 

 

https://soa.arcacontinental.com/services/CargoCorrectionService 

 

Sistema Consumidor: Supervisor de Almacén 

 

Sistema Proveedor: WMS 

 

Entradas 

IdCarga 

CodigoLPN 

Motivo 

Salidas 

Estado 

Observacion 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 14. Generación de Guía 

 

Código del Servicio: Svc_014 

 

Descripción: 

Genera la guía de remisión electrónica para el transporte de mercancías y la envía al ERP para su validación. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: GenerarGuiaRemision 

 

Endpoint 

 

https://soa.arcacontinental.com/services/GuideService 

 

Sistema Consumidor: ERP SAP 

 

Sistema Proveedor: Servicio de Facturación Electrónica 

 

Entradas 

NumeroPedido 

RUCCliente 

PlacaVehiculo 

FechaDespacho 

Salidas 

NumeroGuia 

EstadoSUNAT 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 15. Optimización de Rutas 

 

Código del Servicio: Svc_015 

 

Descripción: 

Calcula la mejor ruta de distribución considerando tráfico, distancia, capacidad del vehículo y ventanas de entrega. 

 

Tipo: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: OptimizarRuta 

 

Endpoint 

 

https://soa.arcacontinental.com/services/RouteOptimizationService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Motor de Optimización Logística 

 

Entradas 

IdRuta 

CentroDistribucion 

Destinos 

Salidas 

RutaOptimizada 

DistanciaTotal 

TiempoEstimado 

 

SOAP Request 

 

 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

Servicio 16. Activación GPS 

 

Código del Servicio: Svc_016 

 

Nombre del Servicio: Activación GPS 

 

Descripción: 

Activa el dispositivo GPS del vehículo antes de iniciar la ruta, permitiendo el monitoreo en tiempo real durante el proceso de distribución. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ActivarGPS 

 

Endpoint 

 

https://soa.arcacontinental.com/services/GPSActivationService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Plataforma de Rastreo GPS 

 

Entradas 

PlacaVehiculo 

IdRuta 

IdConductor 

Salidas 

EstadoGPS 

HoraActivacion 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 17. Geocercas 

 

Código del Servicio: Svc_017 

 

Descripción: 

Controla el ingreso y salida del vehículo en zonas previamente definidas mediante geocercas. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ValidarGeocerca 

 

Endpoint 

 

https://soa.arcacontinental.com/services/GeofenceService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Plataforma GPS 

 

Entradas 

IdVehiculo 

Latitud 

Longitud 

Salidas 

EstadoGeocerca 

Zona 

HoraRegistro 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 18. Registro de Incidencias 

 

Código del Servicio: Svc_018 

 

Descripción: 

Registra incidencias ocurridas durante la distribución, como accidentes, retrasos o problemas con la mercancía. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: RegistrarIncidencia 

 

Endpoint 

 

https://soa.arcacontinental.com/services/IncidentService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: TMS 

 

Entradas 

IdRuta 

TipoIncidencia 

Descripcion 

FechaHora 

Salidas 

IdIncidencia 

EstadoRegistro 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 19. Re-ruteo Dinámico 

 

Código del Servicio: Svc_019 

 

Descripción: 

Calcula automáticamente una nueva ruta cuando ocurre una incidencia que afecta el recorrido planificado. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: RerutearVehiculo 

 

Endpoint 

 

https://soa.arcacontinental.com/services/DynamicRoutingService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Motor de Optimización de Rutas 

 

Entradas 

IdRuta 

IdIncidencia 

UbicacionActual 

Salidas 

NuevaRuta 

TiempoEstimado 

Estado 

 

SOAP Request 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 20. Notificación al Cliente 

 

Código del Servicio: Svc_020 

 

Nombre del Servicio: Notificación al Cliente 

 

Descripción: 

Envía una notificación al cliente informando el estado de su pedido y la proximidad de la entrega. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: NotificarCliente 

 

Endpoint 

 

https://soa.arcacontinental.com/services/CustomerNotificationService 

 

Sistema Consumidor: TMS 

 

Sistema Proveedor: Plataforma de Notificaciones 

 

Entradas 

IdPedido 

IdCliente 

EstadoEntrega 

HoraEstimada 

Salidas 

EstadoNotificacion 

FechaEnvio 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 21. Descarga de Productos 

 

Código del Servicio: Svc_021 

 

Nombre del Servicio: Descarga de Productos 

 

Descripción: 

Registra la descarga de los productos en el punto de entrega, verificando que la mercancía sea entregada al cliente conforme al pedido programado. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: DescargarProductos 

 

Endpoint 

 

https://soa.arcacontinental.com/services/ProductUnloadingService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: TMS 

 

Entradas 

IdPedido 

IdCliente 

CodigoLPN 

FechaEntrega 

Salidas 

EstadoDescarga 

HoraDescarga 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

Servicio 22. Validación vs Factura 

 

Código del Servicio: Svc_022 

 

Descripción: 

Verifica que los productos entregados coincidan con la factura electrónica emitida por el ERP. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: ValidarFactura 

 

Endpoint 

 

https://soa.arcacontinental.com/services/InvoiceValidationService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: ERP SAP 

 

Entradas 

NumeroFactura 

IdPedido 

Salidas 

EstadoValidacion 

Diferencias 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

Servicio 23. Gestión de Retornables 

 

Código del Servicio: Svc_023 

 

Descripción: 

Registra los envases retornables recuperados durante la entrega para su posterior control logístico. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: RegistrarRetornables 

 

Endpoint 

 

https://soa.arcacontinental.com/services/ReturnableManagementService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: ERP 

 

Entradas 

IdCliente 

CantidadEnvases 

TipoEnvase 

Salidas 

EstadoRegistro 

TotalRegistrado 

 

SOAP Request 

Texto

Descripción generada automáticamente 

 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

Servicio 24. Cobranza 

 

Código del Servicio: Svc_024 

 

Descripción: 

Registra el pago realizado por el cliente y actualiza el estado financiero del pedido. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: RegistrarCobranza 

 

Endpoint 

 

https://soa.arcacontinental.com/services/PaymentService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: ERP Financiero 

 

Entradas 

IdPedido 

Monto 

MedioPago 

Salidas 

EstadoPago 

NumeroOperacion 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

 

Texto

Descripción generada automáticamente 

 

Servicio 25. Firma Digital (POD) 

 

Código del Servicio: Svc_025 

 

Nombre del Servicio: Firma Digital (Proof of Delivery) 

 

Descripción: 

Registra la firma digital del cliente como evidencia de la recepción conforme de la mercancía entregada. 

 

Tipo de Servicio: SOAP 

 

Método HTTP: POST 

 

Operación SOAP: RegistrarFirmaDigital 

 

Endpoint 

 

https://soa.arcacontinental.com/services/DigitalSignatureService 

 

Sistema Consumidor: Aplicación del Conductor 

 

Sistema Proveedor: Plataforma POD 

 

Entradas 

IdPedido 

IdCliente 

FirmaBase64 

FechaEntrega 

Salidas 

EstadoFirm 

CodigoConfirmacion 

Mensaje 

 

SOAP Request 

 

Texto

Descripción generada automáticamente 

 

SOAP Response 

 

Texto

Descripción generada automáticamente 

 

 

 

 

10.8 Servicios SOA de los procesos 

 

La solución propuesta para el proceso de gestión logística de Arca Continental se fundamenta en una Arquitectura Orientada a Servicios (SOA), la cual permite desacoplar las funcionalidades del negocio en servicios independientes, reutilizables e interoperables. Esta arquitectura facilita la comunicación entre los sistemas ERP, WMS, TMS, la aplicación móvil del conductor y los servicios externos, garantizando la integración de toda la cadena logística, desde la recepción del pedido hasta el cierre administrativo del proceso. 

 

Los cuarenta servicios identificados fueron diseñados siguiendo los principios fundamentales de SOA: reutilización, bajo acoplamiento, alta cohesión, interoperabilidad y autonomía. Cada servicio encapsula una función específica del negocio y puede ser consumido por diferentes aplicaciones sin depender de la tecnología utilizada por cada una de ellas. 

 

10.8.1 Clasificación de los servicios SOA 

 

Con el propósito de organizar los servicios de acuerdo con su responsabilidad dentro de la arquitectura empresarial, estos fueron clasificados en cuatro categorías principales: Integration Services, Utility Services, Business Services y Application Services. 

 

Tipo de Servicio SOA 

Servicios 

Función principal 

Integration Services 

Svc_001, Svc_014, Svc_032, Svc_040 

Integrar la información entre ERP, WMS, TMS y sistemas externos. 

Utility Services 

Svc_007, Svc_008, Svc_016, Svc_017, Svc_020, Svc_023, Svc_025, Svc_029, Svc_030, Svc_035, Svc_036, Svc_037 y Svc_038 

Proporcionar funcionalidades reutilizables para múltiples procesos empresariales. 

Business Services 

Svc_002, Svc_003, Svc_005, Svc_015, Svc_018, Svc_019, Svc_024, Svc_028, Svc_031, Svc_033 y Svc_039 

Implementar las reglas del negocio relacionadas con la distribución logística. 

Application Services 

Svc_004, Svc_006, Svc_009, Svc_010, Svc_011, Svc_012, Svc_013, Svc_021, Svc_022, Svc_026, Svc_027 y Svc_034 

Ejecutar tareas operativas mediante las aplicaciones utilizadas por los usuarios. 

 

Cada categoría cumple un papel específico dentro de la arquitectura SOA, permitiendo separar las responsabilidades funcionales y reducir el acoplamiento entre aplicaciones. 

 

10.8.2 Relación de los servicios SOA con el proceso logístico 

 

Los servicios SOA fueron identificados siguiendo las cinco fases definidas en el modelo BPMN desarrollado en Bizagi, permitiendo que cada actividad del proceso sea ejecutada mediante servicios independientes. 

 

Fase del proceso 

Servicios SOA involucrados 

Preparación de pedidos 

Svc_001 al Svc_008 

Carga de transporte 

Svc_009 al Svc_014 

Distribución logística 

Svc_015 al Svc_020 

Entrega al cliente 

Svc_021 al Svc_026 

Liquidación y cierre 

Svc_027 al Svc_040 

 

Esta distribución garantiza que cada etapa del proceso logístico sea soportada por servicios especializados, facilitando la automatización y la integración entre los diferentes sistemas de información. 

 

10.8.3 Función de cada categoría de servicios SOA 

a) Integration Services 

 

Los Integration Services tienen como finalidad integrar los diferentes sistemas que participan en la operación logística. Estos servicios permiten intercambiar información entre el ERP, el WMS, el TMS y servicios externos como la emisión de guías electrónicas. 

 

Dentro de esta categoría se encuentran: 

 

Svc_001 – Sincronización ERP–WMS 

Svc_014 – Generación de guía 

Svc_032 – Actualización automática de stock 

Svc_040 – Cierre del pedido ERP 

 

Estos servicios garantizan que toda la información permanezca sincronizada durante el ciclo de vida del pedido, evitando inconsistencias entre los sistemas corporativos. 

 

b) Utility Services 

 

Los Utility Services encapsulan funcionalidades reutilizables que pueden ser utilizadas por distintos procesos empresariales sin necesidad de modificar su lógica de negocio. 

 

Esta categoría incluye los siguientes servicios: 

 

Svc_007 – Etiquetado LPN 

Svc_008 – Validación de inventario 

Svc_016 – Activación GPS 

Svc_017 – Geocercas 

Svc_020 – Notificación al cliente 

Svc_023 – Gestión de retornables 

Svc_025 – Firma digital (POD) 

Svc_029 – Validación de cliente 

Svc_030 – Consulta de estado del pedido 

Svc_035 – Monitoreo de temperatura 

Svc_036 – Gestión de mantenimiento vehicular 

Svc_037 – Auditoría de transacciones 

Svc_038 – Gestión de alertas operativas 

 

Su reutilización permite que diversas aplicaciones corporativas compartan la misma funcionalidad, reduciendo la duplicidad de procesos. 

 

c) Business Services 

 

Los Business Services representan las reglas centrales del negocio y constituyen el núcleo funcional del proceso logístico. 

 

Los servicios pertenecientes a esta categoría son: 

 

Svc_002 – Planificación de oleadas 

Svc_003 – Generación de picking 

Svc_005 – Control de calidad 

Svc_015 – Optimización de rutas 

Svc_018 – Registro de incidencias 

Svc_019 – Re-ruteo dinámico 

Svc_024 – Cobranza 

Svc_028 – Liquidación 

Svc_031 – Gestión de devoluciones 

Svc_033 – Validación de documentos de transporte 

Svc_039 – Programación de ventanas de entrega 

 

Estos servicios contienen la lógica de negocio necesaria para garantizar que la distribución se ejecute conforme a las políticas operativas de Arca Continental. 

 

d) Application Services 

 

Los Application Services ejecutan las tareas operativas realizadas por los usuarios mediante aplicaciones móviles, terminales de radiofrecuencia o sistemas internos. 

 

Esta categoría comprende: 

 

Svc_004 – Ejecución de picking 

Svc_006 – Consolidación y estibado 

Svc_009 – Asignación de bahía 

Svc_010 – Validación de transportista 

Svc_011 – Carga de mercancía 

Svc_012 – Escaneo de carga 

Svc_013 – Corrección de carga 

Svc_021 – Descarga de productos 

Svc_022 – Validación versus factura 

Svc_026 – Recepción del cliente 

Svc_027 – Retorno al centro de distribución 

Svc_034 – Validación de capacidad vehicular 

 

Estos servicios permiten la interacción directa entre los operadores logísticos y los sistemas de información que soportan el proceso. 

 

10.8.4 Orquestación de los servicios SOA 

 

La arquitectura propuesta implementa una orquestación basada en procesos, donde cada servicio es ejecutado de manera secuencial según el flujo definido en el modelo BPMN desarrollado en Bizagi. 

 

El proceso inicia cuando el ERP registra un pedido comercial y consume el servicio Sincronización ERP–WMS (Svc_001), permitiendo que el WMS genere las actividades de planificación de oleadas, generación y ejecución del picking. Posteriormente, los servicios de control de calidad, consolidación y etiquetado LPN preparan la mercancía para el despacho. 

 

Una vez preparada la carga, el sistema ejecuta los servicios de asignación de bahía, validación del transportista, carga física de la mercancía, escaneo y corrección de carga cuando corresponda. Antes de autorizar la salida del vehículo, se genera electrónicamente la guía de remisión mediante el servicio de integración con el ERP. 

 

Durante la distribución, el TMS consume continuamente los servicios de optimización de rutas, activación del GPS, geocercas y monitoreo de temperatura. Si ocurre una incidencia durante el recorrido, se ejecutan los servicios de registro de incidencias, gestión de alertas operativas y re-ruteo dinámico para garantizar la continuidad del servicio. 

 

Al llegar al cliente, el sistema ejecuta los servicios de notificación, validación del cliente, descarga de productos, validación contra la factura, cobranza, gestión de retornables y firma digital (POD), registrando la conformidad de la entrega. 

 

Finalmente, cuando el vehículo retorna al centro de distribución, se ejecutan los servicios de liquidación administrativa, gestión de devoluciones, actualización automática del inventario, auditoría de transacciones y cierre definitivo del pedido en el ERP. 

 

La orquestación de estos cuarenta servicios permite que todo el proceso logístico funcione de forma integrada, garantizando la interoperabilidad entre los sistemas corporativos, la reutilización de funcionalidades y la automatización de las operaciones críticas de distribución. 

 

10.9 Segmentación de la capa empresarial 

 

Esta segmentación organiza los componentes arquitectónicos del proyecto en capas lógicas e independientes, garantizando la escalabilidad, el bajo acoplamiento y la alta reutilización de servicios en el proceso de gestión de pedidos y distribución. 

 

Capa de presentación: 

 

Contiene las interfaces de usuario y canales mediante los cuales los distintos actores interactúan con el sistema logístico y comercial.  

Portal Comercial / WebApp (SAP ERP): Interfaz utilizada por el equipo comercial y administrativo para ingresar, validar y monitorear los pedidos iniciales.  

App Móvil del Repartidor / Conductor: Aplicación nativa/híbrida utilizada por los transportistas en ruta para registrar la descarga, capturar la firma digital (POD), reportar incidencias y procesar la cobranza en el punto de venta.  

Terminal/Handheld del Operario de Almacén: Dispositivos móviles utilizados en los centros de distribución para la ejecución de picking, escaneo de pallets (LPN) y control de calidad. 

 

Capa de procesos de negocio: 

 

Orquesta las actividades, tareas secuenciales y reglas de negocio automatizadas que guían el ciclo de vida del pedido desde su creación hasta su liquidación.  

Orquestador Logístico Central (Comp_DespachoYDistribucion): Componente BPEL que coordina de principio a fin las 5 fases esenciales del negocio: Preparación de Pedidos, Carga de Transporte, Distribución Logística, Entrega al Cliente y Liquidación Administrativa.  

Motor de Reglas de Negocio (Validación de Carga): Evalúa dinámicamente si los pesos y volúmenes cumplen con las restricciones físicas antes del despacho o si se requiere una corrección de carga manual por incidencias. 

 

 

 

Capa de servicios: 

 

Contiene el catálogo de servicios SOA interconectados, expuestos mediante contratos e interfaces estandarizadas (REST/JSON y SOAP/XML).  

Servicios de Orquestación: Comp_DespachoYDistribucion.  

Servicios de Negocio / Entidad: Servicios núcleo como Svc_ValidarStock, Svc_CargaMercancia, Svc_Cobranza y Svc_GestionRetornables.  

Servicios de Utilidad / Tarea: Funcionalidades de apoyo altamente reutilizables como Svc_OptimizarRuta, Svc_ActivacionGPS, Svc_Geocercas, Svc_NotificacionCliente y Svc_RegistrarFirmaDigital 

 

 

Capa de integración: 

 

Actúa como la infraestructura intermedia (Enterprise Service Bus / API Gateway) encargada del enrutamiento, la transformación de datos, la seguridad (Zero Trust / JWT) y la interoperabilidad técnica.  

MuleSoft Anypoint Platform: Plataforma ESB que hospeda los flujos lógicos (Flow_Crear_Pedido, Flow_Validar_Stock, etc.) implementados para conectar los sistemas internos y externos.  

API Gateway: Encargado de la validación estructural de los mensajes JSON, validación sintáctica frente a esquemas y aplicación de políticas de seguridad RBAC. 

Capa de datos: 

 

Garantiza la persistencia, consistencia e integridad de la información operativa, transaccional y de auditoría del sistema.  

Base de Datos Transaccional (ERP/WMS/TMS Databases): Almacenamiento descentralizado de tablas críticas: pedidos, inventarios de productos, registros de despacho, geocercas y datos de clientes.  

Repositorio Documental y de Evidencias: Servidor de almacenamiento seguro para las firmas digitales (POD) encriptadas en SHA-256 y las copias de seguridad de las guías de remisión.  

Servicio de Auditoría de Transacciones (Logs): Componentes Logger encargados de persistir eventos críticos de seguridad para el monitoreo post-ejecución. 

 

Capa de infraestructura: 

 

Provee el soporte físico, virtual y de conectividad de red indispensable para la ejecución continua de las aplicaciones y servicios.  

Servidor Local de Desarrollo (Mule Runtime en Port 8081): Entorno de ejecución donde se despliegan e integran localmente las APIs REST del proyecto.  

Infraestructura de Conectividad y Redes: Protocolos HTTPS seguros para la comunicación cifrada de datos en tránsito y pasarelas de red para el consumo de servicios web externos.  

Hardware de Dispositivos de Campo: Antenas GPS vehiculares, sensores de control de temperatura de la carga y redes móviles (4G/5G) que habilitan las llamadas en tiempo real de los conductores. 

 

 

10.10 Diagrama de proceso con integración empresarial 

 

Representación Estructurada del Flujo de Integración  

Para tu herramienta de modelado (Bizagi), el diagrama debe estructurarse con carriles (Pools/Lanes) y las llamadas específicas a los servicios integrados en cada fase del negocio 

Diagrama BPMN/Bizagi mostrando las llamadas a ERP, WMS, TMS, App del conductor, SUNAT, etc. 

 

 

 

 

 

 

 

Explicación breve del flujo 

Aquí tienes una versión mucho más resumida, directa y precisa, ideal para mantener un impacto técnico limpio en tu documento sin perder el rigor de la arquitectura SOA: 

 

FASE 1: PREPARACIÓN DE PEDIDOS (WMS & ALMACÉN) 

Integración: El pedido aprobado en el ERP (SAP) gatilla de forma síncrona el servicio Svc_SincronizacionERP_WMS para replicar la orden en el WMS. 

Operación: Se ejecutan en secuencia los servicios Svc_PlanificacionOleadas, Svc_GeneracionPicking y Svc_EjecucionPicking para la recolección física de las bebidas. 

Cierre: Se valida el proceso mediante Svc_ControlCalidad y Svc_ConsolidacionEstibado, se asigna la matrícula única del pallet con Svc_EtiquetadoLPN y se descuenta el stock lógico a través de Svc_ValidacionInventario. 

 

 

FASE 2: CARGA DE TRANSPORTE (LOGÍSTICA DE SALIDA) 

Seguridad: Los servicios Svc_AsignacionBahia y Svc_ValidacionTransportista controlan el acceso físico al centro de distribución. 

Control: Se evalúa la documentación y capacidad del camión mediante Svc_ValidacionDocumentosTransporte y Svc_ValidacionCapacidadVehicular, registrando la estiba con Svc_EscaneoCarga (y resolviendo errores con Svc_CorreccionCarga). 

Legal: Con la carga validada, la arquitectura SOA invoca el servicio de integración Svc_GeneracionGuiaSUNAT para emitir la Guía de Remisión Electrónica directamente ante la SUNAT. 

 

 

 

 

FASE 3: DISTRIBUCIÓN LOGÍSTICA (TMS & TRACKING) 

Ruteo: Al salir el transporte, se invoca el servicio Svc_OptimizacionRutas en el TMS para calcular los trayectos óptimos por algoritmos de tráfico. 

Telemetría: Se activa el rastreo en tiempo real mediante Svc_ActivacionGPS, el control de perímetros con Svc_Geocercas y el aseguramiento de la cadena de frío con Svc_MonitoreoTemperaturaCarga. 

Resiliencia: Ante cualquier imprevisto vial, la App del Conductor reporta la alerta mediante Svc_Registrolncidencias, disparando en el TMS el servicio Svc_ReRuteoDinamico. 

 

FASE 4: ENTREGA AL CLIENTE (PUNTO DE VENTA & APP CONDUCTOR) 

Arribo: Al cruzar el perímetro comercial, se dispara el servicio Svc_NotificacionCliente vía SMS/Push alertando la llegada del camión. 

Validación: El repartidor usa la App del Conductor para consumir los servicios de Svc_DescargaProductos, Svc_ValidacionFactura, y procesa la logística inversa de envases con Svc_GestionRetornables. 

Cierre de Entrega: Se ejecuta la transacción financiera con Svc_Cobranza y se captura la conformidad del cliente mediante el servicio Svc_FirmaDigitalPOD, procesando el cierre final de la orden con Svc_RecepcionCliente. 

FASE 5: LIQUIDACIÓN Y CIERRE (ADMINISTRATIVO & ERP) 

Retorno: El vehículo ingresa de vuelta al centro de distribución registrándose con el servicio Svc_RetornoCD. 

Consolidación: El servicio de negocio Svc_Liquidacion cuadra de forma masiva los cobros realizados, envases retornados y las evidencias digitales de las firmas POD entregadas. 

Sincronización ERP: La capa SOA orquesta el cierre total del ciclo invocando los servicios Svc_ActualizacionStockAutomatico (para conciliar inventarios WMS-ERP) y Svc_CierrePedidoERP, marcando la orden en SAP como "Completada y Liquidada". 

 

 

 

10.11 Simulación del proceso 

 

Resultados de la simulación en Bizagi. 

Tiempo promedio del proceso. 

Cuellos de botella. 

Recursos utilizados. 

Indicadores obtenidos. 

 

10.12 Modelo de ciclo de vida BPM del proyecto 

 

Diseño. 

Modelado. 

Implementación. 

Ejecución. 

Monitoreo. 

Optimización continua. 