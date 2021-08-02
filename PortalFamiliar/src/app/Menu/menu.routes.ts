import { Routes, RouterModule } from '@angular/router';
import { Menu } from './menu.component';


// noinspection TypeScriptValidateTypes
const routes: Routes = [
  {
    path: '', component: Menu, children:
      [
        { path: 'Inicio', loadChildren: '../Home/home.module#HomeModule' },
        { path: 'DatosFamilia', loadChildren: '../DatosFamilia/datosFamilia.module#DatosFamiliaModuleModule' },
        { path: 'DocumentosPagados', loadChildren: '../documentosPagados/documentospagados.module#DoctosPagadosModule' },
        { path: 'datosFacturacion', loadChildren: '../datosFacturacion/datosFacturacion.module#DatosFacturacionModule' },
        { path: 'facturas', loadChildren: '../facturas/facturas.module#FacturasModule' },
        { path: 'inscripcionesColegiaturas', loadChildren: '../inscripcionesColegiaturas/inscripcionesColegiaturas.module#InscripcionesColegiaturasModule' },
        { path: 'otrosPagos', loadChildren: '../otrosPagos/otrosPagos.module#OtrosPagosModule' },
        { path: 'SolicitudBeca', loadChildren: '../solicitudesbeca/solicitudesbeca.module#SolicitudesBecaModule' },
        { path: 'DirectorioEscolar', loadChildren: '../DirectorioEscolar/directorioescolar.module#DirectorioEscolarModule' },
        { path: 'inscripcionTalleres', loadChildren: '../inscripcionTalleres/inscripciontalleres.module#InscripciontalleresModule' },
        { path: 'inscripcionTalleresCurriculares', loadChildren: '../inscripcionTalleresCurriculares/inscripciontallerescurriculares.module#InscripciontallerescurricularesModule' },
        { path: 'Disciplina', loadChildren: '../Disciplina/disciplina.module#DisciplinaModule' },
        { path: 'transporte', loadChildren: '../transporte/transporte.module#TransporteModule' },
        { path: 'inasistencias', loadChildren: '../inasistencias/inasistencias.module#InasistenciasModule' },
        { path: 'extraordinarios', loadChildren: '../extraordinarios/extraordinarios.module#ExtraordinariosModule' },
        { path: 'horariosclase', loadChildren: '../horariosclase/horariosclase.module#HorariosclaseModule' },
        { path: 'Notificacion', loadChildren: '../Notificacion/notificacion.module#NotificacionModule' },
        { path: 'calificaciones', loadChildren: '../calificaciones/calificaciones.module#CalificacionesModule' },
        { path: 'reinscripcion', loadChildren: '../reinscripcion/reinscripcion.module#ReinscripcionesModule' },
        { path: '**', redirectTo: 'Inicio', pathMatch: 'full' },
      ]
  }
];
export const ROUTES = RouterModule.forChild(routes);
