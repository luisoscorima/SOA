package pe.edu.utp.arcacontinental.wms.service;

import pe.edu.utp.arcacontinental.wms.model.ValidacionInventarioRequest;
import pe.edu.utp.arcacontinental.wms.model.ValidacionInventarioRequestActualizar;
import pe.edu.utp.arcacontinental.wms.model.ValidacionInventarioResponseActualizarExito;
import pe.edu.utp.arcacontinental.wms.model.ValidacionInventarioResponseConsultaExito;
import pe.edu.utp.arcacontinental.wms.model.ValidacionInventarioResponseExito;

/**
 * Interfaz pública del Servicio SOA: Svc_ValidacionInventario
 */
public interface InventarioService {

    // GET /inventario/validar
    ValidacionInventarioResponseExito validarInventario(String idProducto, Integer cantidad, String idAlmacen);

    // POST /inventario/validaciones
    ValidacionInventarioResponseExito registrarValidacionInventario(ValidacionInventarioRequest request);

    // GET /inventario/validaciones/{id_validacion}
    ValidacionInventarioResponseConsultaExito consultarValidacionInventario(String idValidacion);

    // PUT /inventario/validaciones/{id_validacion}
    ValidacionInventarioResponseActualizarExito actualizarValidacionInventario(
            String idValidacion,
            ValidacionInventarioRequestActualizar request);
}
