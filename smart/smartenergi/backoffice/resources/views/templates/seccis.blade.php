<style>
body{
	font-family:arial;
}
p{
	font-family:arial;
}
table th{
	background: #666;
	color: #fff;
	border:1px solid #ccc;
	border-collapse: collapse;
}
table td{
	border:1px solid #ccc;
	border-collapse: collapse;
	vertical-align:top;
	width:50%;
}
table{
	border:1px solid #ccc;
	border-collapse: collapse;
	margin: 0 0 20px 0;
}
h1{
	text-align:center;
}
ol li, ul li{
	margin-bottom:15px;
}
ul{
	margin-top:15px;
}
h4{
	margin:0;
}
p{
	margin:0 0 10px 0;
}
</style>

<div class="container">
	<div class="content">
		
		<div style="width:90%; margin:0 auto; text-align:center;">
			
			<h1>INFORMACIÓN NORMALIZADA EUROPEA SOBRE EL CRÉDITO AL CONSUMO</h1>
			
		</div>
		
		<h3>1.Identidad y detalles de contacto del prestamista/intermediario</h3>
		
		<table border="1" cellspacing="0" cellpadding="10" width="100%">
			
			<tr>
				<td>Prestamista</td>
				<td>Smartcredites, S.L (<strong>{{$company_number}}</strong>)</td>
			</tr>
			<tr>
				<td>Dirección</td>
				<td><strong>{!!$company_address!!}</strong></td>
			</tr>
			<tr>
				<td>Número de teléfono</td>
				<td><strong>{{$company_phone_no}}</strong></td>
			</tr>
			<tr>
				<td>Correo electrónico</td>
				<td><strong>{{$company_official_email_address}}</strong></td>
			</tr>
			<tr>
				<td>Dirección de página web</td>
				<td><strong>{{$company_web_url}}</strong></td>
			</tr>
			
		</table>
		
		<h3>2. Descripción de las características principales del crédito</h3>
		
		<table border="1" cellspacing="0" cellpadding="10" width="100%">
			
			<tr>
				<td>Tipo de crédito</td>
				<td>
					<p>Crédito al consumo</p>
					<p>Contrato regido por la Ley 16/2011, de 24 de junio, de contratos de Crédito al Consumo, la ley 22/2007, de 11 de julio, sobre Comercialización a distancia de Servicios Financieros Destinados a los Consumidores.</p>
				</td>
			</tr>
			<tr>
				<td>Importe total del crédito</td>
				<td>El límite del Crédito al consumo máximo es de <strong>{{$amount}}&euro;</strong>, aunque la cantidad otorgada estará condicionada por la evaluación de riesgo de crédito llevada a cobo por Smart Credit. El límite de disposición del Crédito podrá será acorde con el precio del servicio a financiar.</td>
			</tr>
			<tr>
				<td>Condiciones que rigen las disposiciones de fondos</td>
				<td>El desembolso se hace a través de transferencia bancaria a una cuenta a nombre del proveedor del servicio, sea clínica o establecimiento que ofrece el servicio a financiar por Smartcredit.es. El desembolso se hará tan pronto como se cumplan todas las condiciones previas (identificación del cliente y verificación cuando sea necesario), y existencia de la aceptación de las condiciones de crédito por parte del Cliente.</td>
			</tr>
			<tr>
				<td>Duración del contrato de crédito</td>
				<td>El acuerdo es por un tiempo indicado en la solicitud, que podrá ser finalizado por cualquiera de las partes de conformidad con los términos y condiciones estándar</td>
			</tr>
			<tr>
				<td>Los plazos y, en su caso, el orden en que se realizarán los pagos a plazos</td>
				<td>
					<p>El Cliente deberá abonar el importe que conste en la factura. La cual será emitida el día 20 de cada mes y el pago deberá realizarse hasta el día 5 de mes siguiente.</p>
					<p>Orden prelación de pagos. Se cubrirán los importes devengados en el siguiente orden:</p>
					<ol>
						<li>Intereses demora</li>
						<li>Comisiones aplicables</li>
						<li>Intereses nominales</li>
						<li>Préstamo</li>
						<li>Coste de recobro (si lo hubiera)</li>
					</ol>
				</td>
			</tr>
			
		</table>
		
		<h3>3. Costes de crédito</h3>
		
		<table border="1" cellspacing="0" cellpadding="10" width="100%">
			
			<tr>
				<td>El tipo deudor o, si procede, los diferentes tipos deudores que se aplican al contrato de crédito</td>
				<td>
					<p>Comisión por disposición: <strong>{{$default_fees}}&euro;</strong></p>
					<p>Tipo de interés Nominal: <strong>{{$default_apr}}%</strong></p>
				</td>
			</tr>
			<tr>
				<td>Tasa Anual Equivalente (APR)</td>
				<td><strong>{{$tae}}%</strong></td>
			</tr>
			<tr>
				<td>¿Es obligatorio para obtener el crédito en sí, o en las condiciones ofrecidas?</td>
				<td></td>
			</tr>
			<tr>
				<td>¿Tomar una póliza de seguros que garantice el crédito, u</td>
				<td>NO</td>
			</tr>
			<tr>
				<td>otro servicio accesorio?</td>
				<td>NO</td>
			</tr>
			<tr>
				<td><h4 style="font-style:italic">Costes relacionados</h4></td>
				<td></td>
			</tr>
			<tr>
				<td>Resto de gastos derivados del contrato de crédito</td>
				<td>No es aplicable</td>
			</tr>
			<tr>
				<td>Condiciones en las que se puede cambiar los costes antes mencionados relacionados con el contrato de crédito</td>
				<td>Se podrán modificar las condiciones del contrato, el cambio será efectivo transcurrido un mes después de la comunicación. El cliente tendrá derecho de aceptar o rechazar dichas modificaciones en el plazo de un mes</td>
			</tr>
			<tr>
				<td>Costes en caso de pagos atrasados</td>
				<td>
					<p>En el caso que el cliente no pague la cantidad mínima de pago acordada en su totalidad a la fecha de vencimiento, el acreedor tendrá derecho a cobrar lo siguiente:</p>
					<p>Si la cantidad mínima de pago no se liquida en su totalidad entre el 1 y 5 siguiente a la Fecha de Vencimiento, el cliente deberá pagar un interés de demora diario del 1% hasta llegar al doble del principal y el interés remuneratorio.</p>
				</td>
			</tr>
			
		</table>
		
		<h3>4. Otros aspectos legales importantes</h3>
		
		<table border="1" cellspacing="0" cellpadding="10" width="100%">
			
			<tr>
				<td>Derecho de desistimiento</td>
				<td>Sí</td>
			</tr>
			<tr>
				<td>
					<p>Reembolso anticipado.</p>
					<p>Usted tiene derecho a reembolsar anticipadamente el crédito en cualquier momento en su totalidad o parcialmente.</p>
				</td>
				<td>En este caso el interés se calculará de manera proporcional al tiempo efectivo durante el cual el cliente haya dispuesto del crédito, desde la fecha de disposición hasta la de reembolso. </td>
			</tr>
			<tr>
				<td>La consulta de una base de datos</td>
				<td>Sí</td>
			</tr>
			<tr>
				<td>Derecho a obtener oferta vinculante del contrato de crédito de forma gratuita</td>
				<td>Sí</td>
			</tr>
			
		</table>
		
		<h3>5. información adicional en el caso de comercialización a distancia de servicios financieros</h3>
		
		<table border="1" cellspacing="0" cellpadding="10" width="100%">
			
			<tr>
				<td colspan="2"><strong>a) relativa al acreedor</strong></td>
			</tr>
			<tr>
				<td colspan="2">Registro</td>
			</tr>
			<tr>
				<td colspan="2">Autoridad de Supervisión</td>
			</tr>
			<tr>
				<td colspan="2"><strong>b) Relativa al contrato de crédito</strong></td>
			</tr>
			<tr>
				<td>Ejercicio derecho desistimiento</td>
				<td>Podrá ejercitarse el derecho de desistimiento dentro del plazo de 14 días naturales desde la fecha de formalización del Contrato de crédito. Mediante correo electrónico a la dirección <strong>{{$company_official_email_address}}</strong></td>
			</tr>
			<tr>
				<td>La ley escogida por el acreedor como ase para el establecimiento de relaciones con usted antes de la celebración del contrato de crédito</td>
				<td>Española</td>
			</tr>
			<tr>
				<td>Cláusula que estipula la ley que rige, aplicable el contrato de crédito y/o el tribunal competente</td>
				<td></td>
			</tr>
			<tr>
				<td>Idioma</td>
				<td>Toda la documentación y las comunicaciones se proporcionarán en catalán y español indistintamente. </td>
			</tr>
			<tr>
				<td><strong>(c) Relativa a Recursos</strong></td>
				<td></td>
			</tr>
			<tr>
				<td>Existencia y acceso a los procedimientos extrajudiciales de reclamación y recurso</td>
				<td>
					<p>El prestatario podrá formular reclamación o queja mediante correo electrónico dirigido a <strong>{{$company_official_email_address}}</strong></p>
					<p>El prestamista responderá a las reclamaciones con un plazo no superior a 7 días naturales.</p>
					<p>En caso de disputa las partes se someterán a los tribunales del domicilio del cliente.</p>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>La cantidad total que tendrá que pagar</td>
				<td>
					
					<p>Importe del préstamo <strong>{{$amount}}&euro;</strong></p>
					<p>Tipo de interés anual <strong>{{$default_apr}}%</strong></p>
					<p>Comisión de apertura <strong>{{$default_fees}}&euro;</strong></p>
					<p>Numero de cuotas <strong>{{$term}}</strong></p>
					<p>Importe de cada cuota <strong>{{$monthly_cost}}&euro;</strong></p>
					<p>TAE: <strong>{{$tae}}%</strong></p>

				</td>
			</tr>
			
		</table>
		
		<br>
		<br>
		
	</div>
</div>
