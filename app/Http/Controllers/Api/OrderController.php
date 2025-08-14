<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
       public function index()
    {
         $result = DB::connection ('sqlsrv2')->select("
select ROW_NUMBER() OVER(ORDER BY sop.U_Supervisor, u.nombres + ' ' + u.apellidos) AS #, c.cliente [Cliente], c.nombre [Nombre], u.nombres + ' ' + u.apellidos Vendedor, cg.descripcion [Status], so.docnum [OV_SAP], sov.DocNum [FC_SAP], v.referencia2, v.venta_id, sop.U_Supervisor [Supervisor], v.total [Total], v.subtotal [SubTotal], v.creado_el
from L360DB..ventas v 
inner join L360DB..clientes c on v.cliente_id =c.cliente_id 
inner join L360DB..usuarios u on v.creado_por =u.usuario_id 
inner join L360DB..rutas r on v.ruta_id = r.ruta_id
inner join L360DB..configuraciones cg on v.estado = cg.valor1 AND cg.configuracion = 'estado venta'
left join SBODRCorporacion..ORDR so on v.venta_id = so.U_logistika_id
left join SBODRCorporacion..OINV sov on v.venta_id = sov.U_logistika_id
left join SBODRCorporacion..OSLP sop ON u.usuario = sop.SlpCode
where tipo_documento = 9 and total is not null and total > 0  and estado not in (3,11) and convert(date,v.fecha_emision,103 ) = convert(date,GETDATE(),103) AND cg.descripcion = 'Sincronizado' ORDER BY Supervisor, Vendedor");
        return response()->json($result);
        
    }
}
