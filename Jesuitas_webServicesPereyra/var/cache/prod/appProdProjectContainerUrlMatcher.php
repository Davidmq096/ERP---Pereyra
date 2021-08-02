<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/Aplicacionentrevista')) {
                // indexAplicacionEntrevista
                if ($pathinfo === '/api/Aplicacionentrevista') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexAplicacionEntrevista;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\AplicacionEntrevistaController::indexAplicacionEntrevista',  '_route' => 'indexAplicacionEntrevista',);
                }
                not_indexAplicacionEntrevista:

                // buscarentrevistas
                if (rtrim($pathinfo, '/') === '/api/Aplicacionentrevista') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_buscarentrevistas;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'buscarentrevistas');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\AplicacionEntrevistaController::buscarAplicacionEntrevista',  '_route' => 'buscarentrevistas',);
                }
                not_buscarentrevistas:

                // buscarentrevistasporid
                if (preg_match('#^/api/Aplicacionentrevista/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_buscarentrevistasporid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'buscarentrevistasporid')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\AplicacionEntrevistaController::buscarAplicacionEntrevistaId',));
                }
                not_buscarentrevistasporid:

                // guardarRespuestas
                if ($pathinfo === '/api/Aplicacionentrevista') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_guardarRespuestas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\AplicacionEntrevistaController::guardarAplicacionEntrevista',  '_route' => 'guardarRespuestas',);
                }
                not_guardarRespuestas:

            }

            if (0 === strpos($pathinfo, '/api/C')) {
                if (0 === strpos($pathinfo, '/api/Ca')) {
                    if (0 === strpos($pathinfo, '/api/Calendarioevaluacion')) {
                        // InicioCalendario
                        if ($pathinfo === '/api/Calendarioevaluacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_InicioCalendario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::indexCalendario',  '_route' => 'InicioCalendario',);
                        }
                        not_InicioCalendario:

                        // BuscarEventoEvaluacion
                        if (rtrim($pathinfo, '/') === '/api/Calendarioevaluacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarEventoEvaluacion;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarEventoEvaluacion');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::busarEvaluador',  '_route' => 'BuscarEventoEvaluacion',);
                        }
                        not_BuscarEventoEvaluacion:

                        // EliminarEventoEvaluacion
                        if (preg_match('#^/api/Calendarioevaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarEventoEvaluacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEventoEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::deleteEventoevaluacion',));
                        }
                        not_EliminarEventoEvaluacion:

                        // GuardarEventoCalendario
                        if ($pathinfo === '/api/Calendarioevaluacion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarEventoCalendario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::saveEventoEvaluacion',  '_route' => 'GuardarEventoCalendario',);
                        }
                        not_GuardarEventoCalendario:

                        if (0 === strpos($pathinfo, '/api/Calendarioevaluacion/Validaciondatos')) {
                            // EventoCalendarioValidacion
                            if (rtrim($pathinfo, '/') === '/api/Calendarioevaluacion/Validaciondatos') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_EventoCalendarioValidacion;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'EventoCalendarioValidacion');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::solicitudComentarioAction',  '_route' => 'EventoCalendarioValidacion',);
                            }
                            not_EventoCalendarioValidacion:

                            // GuardarEventoCalendarioValidacion
                            if ($pathinfo === '/api/Calendarioevaluacion/Validaciondatos') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardarEventoCalendarioValidacion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::saveEventoEvaluacionValidadcion',  '_route' => 'GuardarEventoCalendarioValidacion',);
                            }
                            not_GuardarEventoCalendarioValidacion:

                        }

                        // ActualizarEventoCalendario
                        if (preg_match('#^/api/Calendarioevaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarEventoCalendario;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEventoCalendario')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CalendarioEvaluacionController::updateEventoEvaluacion',));
                        }
                        not_ActualizarEventoCalendario:

                    }

                    if (0 === strpos($pathinfo, '/api/Categoriaapoyo')) {
                        // indexCategoriaapoyo
                        if ($pathinfo === '/api/Categoriaapoyo') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexCategoriaapoyo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CategoriaApoyoController::indexCategoriaapoyo',  '_route' => 'indexCategoriaapoyo',);
                        }
                        not_indexCategoriaapoyo:

                        // BuscarCategoriaapoyo
                        if (rtrim($pathinfo, '/') === '/api/Categoriaapoyo') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarCategoriaapoyo;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarCategoriaapoyo');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CategoriaApoyoController::getCategoriaapoyo',  '_route' => 'BuscarCategoriaapoyo',);
                        }
                        not_BuscarCategoriaapoyo:

                        // EliminarCategoriaapoyo
                        if (preg_match('#^/api/Categoriaapoyo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarCategoriaapoyo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCategoriaapoyo')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CategoriaApoyoController::deleteCategoriaapoyo',));
                        }
                        not_EliminarCategoriaapoyo:

                        // GuardarCategoriaapoyo
                        if ($pathinfo === '/api/Categoriaapoyo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarCategoriaapoyo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CategoriaApoyoController::SaveCategoriaapoyo',  '_route' => 'GuardarCategoriaapoyo',);
                        }
                        not_GuardarCategoriaapoyo:

                        // ActualizarCategoriaapoyo
                        if (preg_match('#^/api/Categoriaapoyo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarCategoriaapoyo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarCategoriaapoyo')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CategoriaApoyoController::updateCategoriaapoyo',));
                        }
                        not_ActualizarCategoriaapoyo:

                    }

                }

                if (0 === strpos($pathinfo, '/api/ConfiguracionBloque')) {
                    // InicioConfiguracion
                    if ($pathinfo === '/api/ConfiguracionBloque') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_InicioConfiguracion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::indexConfiguracion',  '_route' => 'InicioConfiguracion',);
                    }
                    not_InicioConfiguracion:

                    // ConfiguracionConsulta
                    if ($pathinfo === '/api/ConfiguracionBloqueConsulta') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ConfiguracionConsulta;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::consultaConfiguracion',  '_route' => 'ConfiguracionConsulta',);
                    }
                    not_ConfiguracionConsulta:

                }

            }

            if (0 === strpos($pathinfo, '/api/BloquePorGrado')) {
                // BloquePorGrado
                if (preg_match('#^/api/BloquePorGrado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BloquePorGrado;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BloquePorGrado')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::BloquePorGrado',));
                }
                not_BloquePorGrado:

                // BloquePorGradoDatosIniciales
                if ($pathinfo === '/api/BloquePorGrado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BloquePorGradoDatosIniciales;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::BloquePorGradoDatosIniciales',  '_route' => 'BloquePorGradoDatosIniciales',);
                }
                not_BloquePorGradoDatosIniciales:

                // BloquePorGradoReporte
                if (0 === strpos($pathinfo, '/api/BloquePorGradoReporte') && preg_match('#^/api/BloquePorGradoReporte/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BloquePorGradoReporte;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BloquePorGradoReporte')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::BloquePorGradoReporte',));
                }
                not_BloquePorGradoReporte:

            }

            // EditarBloquePorGrado
            if (0 === strpos($pathinfo, '/api/EditarBloquePorGrado') && preg_match('#^/api/EditarBloquePorGrado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'PUT') {
                    $allow[] = 'PUT';
                    goto not_EditarBloquePorGrado;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'EditarBloquePorGrado')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::EditarBloquePorGrado',));
            }
            not_EditarBloquePorGrado:

            // GuardarBloqueGrado
            if ($pathinfo === '/api/GuardarBloqueGrado') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_GuardarBloqueGrado;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::GuardarBloqueGrado',  '_route' => 'GuardarBloqueGrado',);
            }
            not_GuardarBloqueGrado:

            // BloquePorGradoEliminar
            if (0 === strpos($pathinfo, '/api/BloquePorGrado') && preg_match('#^/api/BloquePorGrado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'DELETE') {
                    $allow[] = 'DELETE';
                    goto not_BloquePorGradoEliminar;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BloquePorGradoEliminar')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConfiguracionBloqueController::EliminarBloquePorGrado',));
            }
            not_BloquePorGradoEliminar:

            // InicioConsultaReportes
            if ($pathinfo === '/api/Admisiones/Consultareportes') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_InicioConsultaReportes;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ConsultaReportesController::indexDocumento',  '_route' => 'InicioConsultaReportes',);
            }
            not_InicioConsultaReportes:

            if (0 === strpos($pathinfo, '/api/Cupoadmision')) {
                // indexCupoAdmision
                if ($pathinfo === '/api/Cupoadmision') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexCupoAdmision;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CupoAdmisionController::indexCupoAdmision',  '_route' => 'indexCupoAdmision',);
                }
                not_indexCupoAdmision:

                // BuscarCuposAdmision
                if (rtrim($pathinfo, '/') === '/api/Cupoadmision') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarCuposAdmision;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarCuposAdmision');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CupoAdmisionController::getCuposAdmision',  '_route' => 'BuscarCuposAdmision',);
                }
                not_BuscarCuposAdmision:

                // EliminarCupoAdmision
                if (preg_match('#^/api/Cupoadmision/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarCupoAdmision;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCupoAdmision')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CupoAdmisionController::deleteCupoAdmision',));
                }
                not_EliminarCupoAdmision:

                // GuardarCupoAdmision
                if ($pathinfo === '/api/Cupoadmision') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarCupoAdmision;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CupoAdmisionController::saveCupoAdmision',  '_route' => 'GuardarCupoAdmision',);
                }
                not_GuardarCupoAdmision:

                // ActualizarCupoAdmision
                if (preg_match('#^/api/Cupoadmision/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarCupoAdmision;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarCupoAdmision')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\CupoAdmisionController::updateCupoAdmision',));
                }
                not_ActualizarCupoAdmision:

            }

            if (0 === strpos($pathinfo, '/api/Documento')) {
                // InicioDocumento
                if ($pathinfo === '/api/Documento') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_InicioDocumento;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoController::indexDocumento',  '_route' => 'InicioDocumento',);
                }
                not_InicioDocumento:

                // BuscarDocumento
                if (rtrim($pathinfo, '/') === '/api/Documento') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarDocumento;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarDocumento');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoController::getDocumento',  '_route' => 'BuscarDocumento',);
                }
                not_BuscarDocumento:

                // GuardarDocumento
                if ($pathinfo === '/api/Documento') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarDocumento;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoController::saveDocumento',  '_route' => 'GuardarDocumento',);
                }
                not_GuardarDocumento:

                // EliminarDocumento
                if (preg_match('#^/api/Documento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarDocumento;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarDocumento')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoController::deleteDocumento',));
                }
                not_EliminarDocumento:

                // ActualizarDocumento
                if (preg_match('#^/api/Documento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarDocumento;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarDocumento')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoController::UpdateDocumento',));
                }
                not_ActualizarDocumento:

                if (0 === strpos($pathinfo, '/api/Documentoporgrado')) {
                    // InicioDocumentoporgrado
                    if ($pathinfo === '/api/Documentoporgrado') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_InicioDocumentoporgrado;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoPorGradoController::indexDocumento',  '_route' => 'InicioDocumentoporgrado',);
                    }
                    not_InicioDocumentoporgrado:

                    // BuscarDocumentoporgrado
                    if (rtrim($pathinfo, '/') === '/api/Documentoporgrado') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarDocumentoporgrado;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarDocumentoporgrado');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoPorGradoController::getDocumento',  '_route' => 'BuscarDocumentoporgrado',);
                    }
                    not_BuscarDocumentoporgrado:

                    // GuardarDocumentoporgrado
                    if ($pathinfo === '/api/Documentoporgrado') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarDocumentoporgrado;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoPorGradoController::saveDocumento',  '_route' => 'GuardarDocumentoporgrado',);
                    }
                    not_GuardarDocumentoporgrado:

                    // EliminarDocumentoporgrado
                    if (preg_match('#^/api/Documentoporgrado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarDocumentoporgrado;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarDocumentoporgrado')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoPorGradoController::deleteDocumento',));
                    }
                    not_EliminarDocumentoporgrado:

                    // ActualizarDocumentoporgrado
                    if (preg_match('#^/api/Documentoporgrado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarDocumentoporgrado;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarDocumentoporgrado')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\DocumentoPorGradoController::UpdateDocumento',));
                    }
                    not_ActualizarDocumentoporgrado:

                }

            }

            if (0 === strpos($pathinfo, '/api/Evalua')) {
                if (0 === strpos($pathinfo, '/api/Evaluacion')) {
                    // indexEvaluacion
                    if ($pathinfo === '/api/Evaluacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexEvaluacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::indexEvaluacion',  '_route' => 'indexEvaluacion',);
                    }
                    not_indexEvaluacion:

                    // BuscarEvaluacion
                    if (rtrim($pathinfo, '/') === '/api/Evaluacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarEvaluacion;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarEvaluacion');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::buscarEvaluacion',  '_route' => 'BuscarEvaluacion',);
                    }
                    not_BuscarEvaluacion:

                    // saveEvaluacion
                    if ($pathinfo === '/api/Evaluacion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveEvaluacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::saveEvaluacion',  '_route' => 'saveEvaluacion',);
                    }
                    not_saveEvaluacion:

                    // updateEvaluacion
                    if (preg_match('#^/api/Evaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateEvaluacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::updateEvaluacion',));
                    }
                    not_updateEvaluacion:

                    // otrocicloEvaluacion
                    if ($pathinfo === '/api/Evaluacion/otrociclo') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_otrocicloEvaluacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::otrocicloEvaluacion',  '_route' => 'otrocicloEvaluacion',);
                    }
                    not_otrocicloEvaluacion:

                    // copiaEvaluacion
                    if ($pathinfo === '/api/Evaluacion/Copia') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_copiaEvaluacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::Copia',  '_route' => 'copiaEvaluacion',);
                    }
                    not_copiaEvaluacion:

                    // BuscarEvaluacionId
                    if (preg_match('#^/api/Evaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarEvaluacionId;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarEvaluacionId')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::buscarEvaluacionId',));
                    }
                    not_BuscarEvaluacionId:

                    if (0 === strpos($pathinfo, '/api/Evaluacion/Pregunta')) {
                        // NuevaPreguntaEvaluacion
                        if ($pathinfo === '/api/Evaluacion/Pregunta') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_NuevaPreguntaEvaluacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::nuevaPreguntaEvaluacionId',  '_route' => 'NuevaPreguntaEvaluacion',);
                        }
                        not_NuevaPreguntaEvaluacion:

                        // EliminarPreguntaEvaluacion
                        if (preg_match('#^/api/Evaluacion/Pregunta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarPreguntaEvaluacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPreguntaEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::eliminarPreguntaEvaluacionId',));
                        }
                        not_EliminarPreguntaEvaluacion:

                    }

                    // EliminarEvaluacion
                    if (preg_match('#^/api/Evaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarEvaluacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::EliminarEvaluacion',));
                    }
                    not_EliminarEvaluacion:

                    // updateEvaluacionFormulario
                    if (preg_match('#^/api/Evaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_updateEvaluacionFormulario;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateEvaluacionFormulario')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluacionController::updateEvaluacionFormulario',));
                    }
                    not_updateEvaluacionFormulario:

                }

                if (0 === strpos($pathinfo, '/api/Evaluador')) {
                    // indexEvaluadores
                    if ($pathinfo === '/api/Evaluador') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexEvaluadores;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluadorController::indexAction',  '_route' => 'indexEvaluadores',);
                    }
                    not_indexEvaluadores:

                    // BuscarEvaluador
                    if (rtrim($pathinfo, '/') === '/api/Evaluador') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarEvaluador;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarEvaluador');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluadorController::getEvaluador',  '_route' => 'BuscarEvaluador',);
                    }
                    not_BuscarEvaluador:

                    // ActualizarEvaluador
                    if (preg_match('#^/api/Evaluador/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarEvaluador;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEvaluador')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\EvaluadorController::updateEvaluador',));
                    }
                    not_ActualizarEvaluador:

                }

            }

            if (0 === strpos($pathinfo, '/api/F')) {
                if (0 === strpos($pathinfo, '/api/Factoresapoyo')) {
                    // indexFactoresapoyo
                    if ($pathinfo === '/api/Factoresapoyo') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexFactoresapoyo;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FactoresApoyoController::indexFactoresapoyo',  '_route' => 'indexFactoresapoyo',);
                    }
                    not_indexFactoresapoyo:

                    // BuscarFactoresapoyo
                    if (rtrim($pathinfo, '/') === '/api/Factoresapoyo') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarFactoresapoyo;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarFactoresapoyo');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FactoresApoyoController::getFactoresapoyo',  '_route' => 'BuscarFactoresapoyo',);
                    }
                    not_BuscarFactoresapoyo:

                    // EliminarFactoresapoyo
                    if (preg_match('#^/api/Factoresapoyo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarFactoresapoyo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarFactoresapoyo')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FactoresApoyoController::deleteFactoresapoyo',));
                    }
                    not_EliminarFactoresapoyo:

                    // GuardarFactoresapoyo
                    if ($pathinfo === '/api/Factoresapoyo') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarFactoresapoyo;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FactoresApoyoController::SaveFactoresapoyo',  '_route' => 'GuardarFactoresapoyo',);
                    }
                    not_GuardarFactoresapoyo:

                    // ActualizarFactoresapoyo
                    if (preg_match('#^/api/Factoresapoyo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarFactoresapoyo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarFactoresapoyo')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FactoresApoyoController::updateFactoresapoyo',));
                    }
                    not_ActualizarFactoresapoyo:

                }

                if (0 === strpos($pathinfo, '/api/Formato')) {
                    // InicioFormato
                    if ($pathinfo === '/api/Formato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_InicioFormato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FormatoController::indexFormato',  '_route' => 'InicioFormato',);
                    }
                    not_InicioFormato:

                    // BuscarFormato
                    if (rtrim($pathinfo, '/') === '/api/Formato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarFormato;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarFormato');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FormatoController::buscarFormato',  '_route' => 'BuscarFormato',);
                    }
                    not_BuscarFormato:

                    // GuardarFormato
                    if ($pathinfo === '/api/Formato') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarFormato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FormatoController::saveFormato',  '_route' => 'GuardarFormato',);
                    }
                    not_GuardarFormato:

                    // DescargarFormato
                    if (0 === strpos($pathinfo, '/api/Formato/descargar') && preg_match('#^/api/Formato/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DescargarFormato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarFormato')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FormatoController::downloadFormato',));
                    }
                    not_DescargarFormato:

                    // ActualizarFormato
                    if (preg_match('#^/api/Formato/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ActualizarFormato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarFormato')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\FormatoController::actualizarFormato',));
                    }
                    not_ActualizarFormato:

                }

            }

            if (0 === strpos($pathinfo, '/api/Importacionresultado')) {
                // indexImportacionResultado
                if ($pathinfo === '/api/Importacionresultado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexImportacionResultado;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ImportacionResultadoController::indexImportacionResultado',  '_route' => 'indexImportacionResultado',);
                }
                not_indexImportacionResultado:

                // downloadLayout
                if (rtrim($pathinfo, '/') === '/api/Importacionresultado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_downloadLayout;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'downloadLayout');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ImportacionResultadoController::downloadLayout',  '_route' => 'downloadLayout',);
                }
                not_downloadLayout:

                // importarLayoutAdmisiones
                if ($pathinfo === '/api/Importacionresultado') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_importarLayoutAdmisiones;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ImportacionResultadoController::importarLayout',  '_route' => 'importarLayoutAdmisiones',);
                }
                not_importarLayoutAdmisiones:

            }

            if (0 === strpos($pathinfo, '/api/L')) {
                if (0 === strpos($pathinfo, '/api/Listaasistencia')) {
                    // indexListaAsistencia
                    if ($pathinfo === '/api/Listaasistencia') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexListaAsistencia;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::indexListaAsistencia',  '_route' => 'indexListaAsistencia',);
                    }
                    not_indexListaAsistencia:

                    // buscarListaAsistencia
                    if (rtrim($pathinfo, '/') === '/api/Listaasistencia') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_buscarListaAsistencia;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'buscarListaAsistencia');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::buscarListaAsistencia',  '_route' => 'buscarListaAsistencia',);
                    }
                    not_buscarListaAsistencia:

                    // DescargarLista
                    if ($pathinfo === '/api/Listaasistencia/Lista/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_DescargarLista;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::downloadLista',  '_route' => 'DescargarLista',);
                    }
                    not_DescargarLista:

                    // buscarAlumnos
                    if ($pathinfo === '/api/Listaasistencia/Alumnos') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_buscarAlumnos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::buscarAlumnos',  '_route' => 'buscarAlumnos',);
                    }
                    not_buscarAlumnos:

                    // ActualizarListaAsistencia
                    if ($pathinfo === '/api/Listaasistencia/') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarListaAsistencia;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::updateListaAsistencia',  '_route' => 'ActualizarListaAsistencia',);
                    }
                    not_ActualizarListaAsistencia:

                    // SaveFoto
                    if ($pathinfo === '/api/Listaasistencia/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SaveFoto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ListaAsistenciaController::saveFoto',  '_route' => 'SaveFoto',);
                    }
                    not_SaveFoto:

                }

                if (0 === strpos($pathinfo, '/api/Lugar')) {
                    // indexLugar
                    if ($pathinfo === '/api/Lugar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexLugar;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\LugaresController::indexAction',  '_route' => 'indexLugar',);
                    }
                    not_indexLugar:

                    // BuscarLugar
                    if (rtrim($pathinfo, '/') === '/api/Lugar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarLugar;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarLugar');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\LugaresController::getLugar',  '_route' => 'BuscarLugar',);
                    }
                    not_BuscarLugar:

                    // EliminarLugar
                    if (preg_match('#^/api/Lugar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarLugar;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarLugar')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\LugaresController::deleteCupoAdmision',));
                    }
                    not_EliminarLugar:

                    // GuardarLugar
                    if ($pathinfo === '/api/Lugar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarLugar;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\LugaresController::saveLugar',  '_route' => 'GuardarLugar',);
                    }
                    not_GuardarLugar:

                    // ActualizarLugar
                    if (preg_match('#^/api/Lugar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarLugar;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarLugar')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\LugaresController::updateLugar',));
                    }
                    not_ActualizarLugar:

                }

            }

            if (0 === strpos($pathinfo, '/api/Solicitud/datoMedico')) {
                // datoMedicoHome
                if ($pathinfo === '/api/Solicitud/datoMedico') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_datoMedicoHome;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\AreaMedicaController::datoMedicoAction',  '_route' => 'datoMedicoHome',);
                }
                not_datoMedicoHome:

                // GuardarDatomedico
                if ($pathinfo === '/api/Solicitud/datoMedico') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarDatomedico;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\AreaMedicaController::SaveDatoMedico',  '_route' => 'GuardarDatomedico',);
                }
                not_GuardarDatomedico:

            }

            // consultaContactos
            if (0 === strpos($pathinfo, '/api/Alumno/Data/ContactoMedico') && preg_match('#^/api/Alumno/Data/ContactoMedico/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_consultaContactos;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'consultaContactos')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\AreaMedicaController::consultaContactos',));
            }
            not_consultaContactos:

            // areamedicaGuardarArea
            if ($pathinfo === '/api/Solicitud/areaMedicaCiencias') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_areamedicaGuardarArea;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\AreaMedicaController::SaveArea',  '_route' => 'areamedicaGuardarArea',);
            }
            not_areamedicaGuardarArea:

            // guardarContactoMedico
            if ($pathinfo === '/api/Alumno/Guardar/ContactoMedico') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_guardarContactoMedico;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\AreaMedicaController::guardarContactoMedico',  '_route' => 'guardarContactoMedico',);
            }
            not_guardarContactoMedico:

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                if (0 === strpos($pathinfo, '/api/Solicitud/comentario')) {
                    // solicitudComentario
                    if (rtrim($pathinfo, '/') === '/api/Solicitud/comentario') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_solicitudComentario;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'solicitudComentario');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ComentariosController::solicitudComentarioAction',  '_route' => 'solicitudComentario',);
                    }
                    not_solicitudComentario:

                    // saveSolicitudComentario
                    if ($pathinfo === '/api/Solicitud/comentario/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveSolicitudComentario;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ComentariosController::saveSolicitudComentarioAction',  '_route' => 'saveSolicitudComentario',);
                    }
                    not_saveSolicitudComentario:

                    // DeleteSolicitudCOmentario
                    if (preg_match('#^/api/Solicitud/comentario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_DeleteSolicitudCOmentario;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DeleteSolicitudCOmentario')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ComentariosController::deleteSolicitudComentarioAction',));
                    }
                    not_DeleteSolicitudCOmentario:

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/datosAspirante')) {
                    // datosAspiranteModal
                    if (preg_match('#^/api/Solicitud/datosAspirante/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_datosAspiranteModal;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'datosAspiranteModal')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatoAspiranteController::getdatosAspiranteModal',));
                    }
                    not_datosAspiranteModal:

                    // DatosAspiranteSaveValidacionDatos
                    if ($pathinfo === '/api/Solicitud/datosAspirante/validacionDatos') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_DatosAspiranteSaveValidacionDatos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatoAspiranteController::saveDatosAspiranteValidacion',  '_route' => 'DatosAspiranteSaveValidacionDatos',);
                    }
                    not_DatosAspiranteSaveValidacionDatos:

                }

            }

            if (0 === strpos($pathinfo, '/api/Familiar/datosAspirante')) {
                // datosAspirante
                if ($pathinfo === '/api/Familiar/datosAspirante') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_datosAspirante;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatoAspiranteController::getdatosAspirante',  '_route' => 'datosAspirante',);
                }
                not_datosAspirante:

                // DatosAspiranteSave
                if ($pathinfo === '/api/Familiar/datosAspirante') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_DatosAspiranteSave;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatoAspiranteController::saveDatosAspirante',  '_route' => 'DatosAspiranteSave',);
                }
                not_DatosAspiranteSave:

            }

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                if (0 === strpos($pathinfo, '/api/Solicitud/dato')) {
                    // SolicitudDatosFamiliares
                    if (0 === strpos($pathinfo, '/api/Solicitud/datoFamiliar') && preg_match('#^/api/Solicitud/datoFamiliar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_SolicitudDatosFamiliares;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudDatosFamiliares')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatosFamiliaresController::SolicitudDatosFamiliares',));
                    }
                    not_SolicitudDatosFamiliares:

                    if (0 === strpos($pathinfo, '/api/Solicitud/datosFamiliares/padres')) {
                        // datosFamiliaresPadresModal
                        if ($pathinfo === '/api/Solicitud/datosFamiliares/padres') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_datosFamiliaresPadresModal;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatosFamiliaresController::savePadresAction',  '_route' => 'datosFamiliaresPadresModal',);
                        }
                        not_datosFamiliaresPadresModal:

                        // datosFamiliaresPadresRemove
                        if ($pathinfo === '/api/Solicitud/datosFamiliares/padres/') {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_datosFamiliaresPadresRemove;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatosFamiliaresController::removePadresAction',  '_route' => 'datosFamiliaresPadresRemove',);
                        }
                        not_datosFamiliaresPadresRemove:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/claveFamiliar')) {
                    // SolicitudClaveFamiliarFilters
                    if (rtrim($pathinfo, '/') === '/api/Solicitud/claveFamiliar/filtros') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_SolicitudClaveFamiliarFilters;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'SolicitudClaveFamiliarFilters');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatosFamiliaresController::claveFamiliarFiltrosAction',  '_route' => 'SolicitudClaveFamiliarFilters',);
                    }
                    not_SolicitudClaveFamiliarFilters:

                    // saveClaveFamiliarbySolicitud
                    if ($pathinfo === '/api/Solicitud/claveFamiliar/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveClaveFamiliarbySolicitud;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DatosFamiliaresController::addClaveFamiliarbySolicitudAction',  '_route' => 'saveClaveFamiliarbySolicitud',);
                    }
                    not_saveClaveFamiliarbySolicitud:

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/Dictaminacion')) {
                    // SolicitudDictaminacion
                    if (preg_match('#^/api/Solicitud/Dictaminacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_SolicitudDictaminacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudDictaminacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::indexDictaminacion',));
                    }
                    not_SolicitudDictaminacion:

                    // SolicitudDictaminacionSave
                    if (preg_match('#^/api/Solicitud/Dictaminacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SolicitudDictaminacionSave;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudDictaminacionSave')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::saveSolicitudDictaminacion',));
                    }
                    not_SolicitudDictaminacionSave:

                    if (0 === strpos($pathinfo, '/api/Solicitud/Dictaminacion/Cartas')) {
                        // SolicitudDictaminacionCartasSave
                        if (preg_match('#^/api/Solicitud/Dictaminacion/Cartas/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_SolicitudDictaminacionCartasSave;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudDictaminacionCartasSave')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::saveCartasbySolicitudction',));
                        }
                        not_SolicitudDictaminacionCartasSave:

                        // SolicitudDictaminacionCartasRemove
                        if (preg_match('#^/api/Solicitud/Dictaminacion/Cartas/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_SolicitudDictaminacionCartasRemove;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudDictaminacionCartasRemove')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::deleteCartasbySolicitudction',));
                        }
                        not_SolicitudDictaminacionCartasRemove:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/Entregaresultados')) {
                    // saveEntregaResultados
                    if (preg_match('#^/api/Solicitud/Entregaresultados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveEntregaResultados;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'saveEntregaResultados')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::saveEntregaResultados',));
                    }
                    not_saveEntregaResultados:

                    // deleteEntregaResultados
                    if (preg_match('#^/api/Solicitud/Entregaresultados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_deleteEntregaResultados;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteEntregaResultados')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::deleteEntregaResultados',));
                    }
                    not_deleteEntregaResultados:

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/Areafortalecer')) {
                    // saveAreaFortalecerSolicitud
                    if (preg_match('#^/api/Solicitud/Areafortalecer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveAreaFortalecerSolicitud;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'saveAreaFortalecerSolicitud')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::saveAreaFortalecer',));
                    }
                    not_saveAreaFortalecerSolicitud:

                    // removeAreaFortalecerSolicitud
                    if (preg_match('#^/api/Solicitud/Areafortalecer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_removeAreaFortalecerSolicitud;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'removeAreaFortalecerSolicitud')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::removeAreaFortalecer',));
                    }
                    not_removeAreaFortalecerSolicitud:

                }

                // CambioGradoDictament
                if ($pathinfo === '/api/Solicitud/CambioGrado/Dictamen') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_CambioGradoDictament;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DictamenController::cambioGradoBySolicitudActionDictmen',  '_route' => 'CambioGradoDictament',);
                }
                not_CambioGradoDictament:

                if (0 === strpos($pathinfo, '/api/Solicitud/d')) {
                    if (0 === strpos($pathinfo, '/api/Solicitud/dinamicaFamiliar')) {
                        // DinamicaFamiliar
                        if (rtrim($pathinfo, '/') === '/api/Solicitud/dinamicaFamiliar') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_DinamicaFamiliar;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'DinamicaFamiliar');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DinamicaFamiliarController::dinamicaFamiliarAction',  '_route' => 'DinamicaFamiliar',);
                        }
                        not_DinamicaFamiliar:

                        // DinamicaFamiliarSave
                        if ($pathinfo === '/api/Solicitud/dinamicaFamiliar/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_DinamicaFamiliarSave;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DinamicaFamiliarController::saveDinamicaFamiliarAction',  '_route' => 'DinamicaFamiliarSave',);
                        }
                        not_DinamicaFamiliarSave:

                    }

                    if (0 === strpos($pathinfo, '/api/Solicitud/documentacion')) {
                        if (0 === strpos($pathinfo, '/api/Solicitud/documentacion/validacion')) {
                            // documentacionValidacion
                            if (rtrim($pathinfo, '/') === '/api/Solicitud/documentacion/validacion') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_documentacionValidacion;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'documentacionValidacion');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DocumentacionController::documentacionValidacionAction',  '_route' => 'documentacionValidacion',);
                            }
                            not_documentacionValidacion:

                            // documentacionValidacionEdit
                            if ($pathinfo === '/api/Solicitud/documentacion/validacion/') {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_documentacionValidacionEdit;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DocumentacionController::saveDocumentacionValidacionAction',  '_route' => 'documentacionValidacionEdit',);
                            }
                            not_documentacionValidacionEdit:

                        }

                        // documentacionSave
                        if ($pathinfo === '/api/Solicitud/documentacion/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_documentacionSave;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\DocumentacionController::saveDocumentacionAction',  '_route' => 'documentacionSave',);
                        }
                        not_documentacionSave:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/encuesta')) {
                    // encuestaModal
                    if (preg_match('#^/api/Solicitud/encuesta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_encuestaModal;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'encuestaModal')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EncuestaController::EncuestaAction',));
                    }
                    not_encuestaModal:

                    // encuestaSave
                    if ($pathinfo === '/api/Solicitud/encuesta/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_encuestaSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EncuestaController::saveEncuestasAction',  '_route' => 'encuestaSave',);
                    }
                    not_encuestaSave:

                }

                // ValidacionDatosEvaluaciones
                if ($pathinfo === '/api/Solicitud/ValidacionDatos/Evaluaciones/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ValidacionDatosEvaluaciones;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EvaluacionController::validacionDatosEvaluacionesAction',  '_route' => 'ValidacionDatosEvaluaciones',);
                }
                not_ValidacionDatosEvaluaciones:

                // evaluacionesCupoUpdateValidacion
                if (rtrim($pathinfo, '/') === '/api/Solicitud/evaluaciones/update') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_evaluacionesCupoUpdateValidacion;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'evaluacionesCupoUpdateValidacion');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EvaluacionController::solicitudUpdateCupoAction',  '_route' => 'evaluacionesCupoUpdateValidacion',);
                }
                not_evaluacionesCupoUpdateValidacion:

                if (0 === strpos($pathinfo, '/api/Solicitud/Ev')) {
                    // evaluacionesCupoSaveValidacion
                    if ($pathinfo === '/api/Solicitud/Evaluaciones/update/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_evaluacionesCupoSaveValidacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EvaluacionController::UpdateEvaluacionPorsolicitud',  '_route' => 'evaluacionesCupoSaveValidacion',);
                    }
                    not_evaluacionesCupoSaveValidacion:

                    // ValidacionDatosEventosFolio
                    if ($pathinfo === '/api/Solicitud/Eventos/Folio') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ValidacionDatosEventosFolio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EvaluacionController::getValidacioEventosByFolio',  '_route' => 'ValidacionDatosEventosFolio',);
                    }
                    not_ValidacionDatosEventosFolio:

                    // removeEventoEvaluacion
                    if (0 === strpos($pathinfo, '/api/Solicitud/Evaluaciones') && preg_match('#^/api/Solicitud/Evaluaciones/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_removeEventoEvaluacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'removeEventoEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\EvaluacionController::remoEventoEvaluacionAction',));
                    }
                    not_removeEventoEvaluacion:

                }

                if (0 === strpos($pathinfo, '/api/Solicitud/expediente')) {
                    // expedienteModal
                    if (preg_match('#^/api/Solicitud/expediente/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_expedienteModal;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'expedienteModal')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ExpedienteController::expedienteAction',));
                    }
                    not_expedienteModal:

                    // expedienteModalSave
                    if ($pathinfo === '/api/Solicitud/expediente/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_expedienteModalSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ExpedienteController::saveExpedienteAction',  '_route' => 'expedienteModalSave',);
                    }
                    not_expedienteModalSave:

                    if (0 === strpos($pathinfo, '/api/Solicitud/expediente/gradorepetido')) {
                        // expedienteModalgradorepetidoSave
                        if ($pathinfo === '/api/Solicitud/expediente/gradorepetido') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_expedienteModalgradorepetidoSave;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ExpedienteController::saveGradoAction',  '_route' => 'expedienteModalgradorepetidoSave',);
                        }
                        not_expedienteModalgradorepetidoSave:

                        // expedienteModalGradosRemove
                        if (preg_match('#^/api/Solicitud/expediente/gradorepetido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_expedienteModalGradosRemove;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'expedienteModalGradosRemove')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\ExpedienteController::removeGradorepetido',));
                        }
                        not_expedienteModalGradosRemove:

                    }

                }

                // SolicitudGuardarFoto
                if ($pathinfo === '/api/Solicitud/GuardarFoto') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_SolicitudGuardarFoto;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\FotoController::solicitudGuardarFoto',  '_route' => 'SolicitudGuardarFoto',);
                }
                not_SolicitudGuardarFoto:

                // OtrosProcesos
                if (rtrim($pathinfo, '/') === '/api/Solicitud/otrosProceso') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_OtrosProcesos;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'OtrosProcesos');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ModalSolicitud\\OtrosProcesosController::OtrosProcesosAction',  '_route' => 'OtrosProcesos',);
                }
                not_OtrosProcesos:

            }

            // reporteadmision
            if ($pathinfo === '/api/admision/reporteadmision') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_reporteadmision;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ReporteAsignacionController::getReporteAsignacionAction',  '_route' => 'reporteadmision',);
            }
            not_reporteadmision:

            if (0 === strpos($pathinfo, '/api/Resultado')) {
                // indexResultado
                if ($pathinfo === '/api/Resultado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexResultado;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ResultadoController::indexResultado',  '_route' => 'indexResultado',);
                }
                not_indexResultado:

                // buscarResultado
                if (rtrim($pathinfo, '/') === '/api/Resultado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_buscarResultado;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'buscarResultado');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\ResultadoController::buscarResultado',  '_route' => 'buscarResultado',);
                }
                not_buscarResultado:

            }

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                // SolicitudAdmisionIndex
                if ($pathinfo === '/api/Solicitud') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudAdmisionIndex;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::indexAction',  '_route' => 'SolicitudAdmisionIndex',);
                }
                not_SolicitudAdmisionIndex:

                // SolicitudFilters
                if ($pathinfo === '/api/Solicitud/Filters') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudFilters;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::solicitudFilterAction',  '_route' => 'SolicitudFilters',);
                }
                not_SolicitudFilters:

                // CambioGrado
                if ($pathinfo === '/api/Solicitud/CambioGrado') {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_CambioGrado;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::cambioGradoBySolicitudAction',  '_route' => 'CambioGrado',);
                }
                not_CambioGrado:

                if (0 === strpos($pathinfo, '/api/Solicitudadmision')) {
                    // ValidacionDatosSaveSolicitud
                    if ($pathinfo === '/api/Solicitudadmision/ValidacionDatos/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ValidacionDatosSaveSolicitud;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::saveSolicitudValidacionDatos',  '_route' => 'ValidacionDatosSaveSolicitud',);
                    }
                    not_ValidacionDatosSaveSolicitud:

                    // SolicitudSave
                    if ($pathinfo === '/api/Solicitudadmision/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SolicitudSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::saveSolicitud',  '_route' => 'SolicitudSave',);
                    }
                    not_SolicitudSave:

                }

            }

            // EnvioCorreoSolicitud
            if (0 === strpos($pathinfo, '/api/Familiar/EnvioCorreoSolicitud') && preg_match('#^/api/Familiar/EnvioCorreoSolicitud/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_EnvioCorreoSolicitud;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'EnvioCorreoSolicitud')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::envioCorreoTemporal',));
            }
            not_EnvioCorreoSolicitud:

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                // SolicitudLogin
                if (rtrim($pathinfo, '/') === '/api/Solicitud/Login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudLogin;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'SolicitudLogin');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::LoginAction',  '_route' => 'SolicitudLogin',);
                }
                not_SolicitudLogin:

                // Solicitudadmision
                if (0 === strpos($pathinfo, '/api/Solicitudadmision') && preg_match('#^/api/Solicitudadmision/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_Solicitudadmision;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'Solicitudadmision')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::getSolicitudadmision',));
                }
                not_Solicitudadmision:

                // SolicitudDownloadFormatoSolicitud
                if (rtrim($pathinfo, '/') === '/api/Solicitud/DownloadFormatoSolicitud') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudDownloadFormatoSolicitud;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'SolicitudDownloadFormatoSolicitud');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::solicitudDownloadFormatoSolicitud',  '_route' => 'SolicitudDownloadFormatoSolicitud',);
                }
                not_SolicitudDownloadFormatoSolicitud:

                // validacionDatosvalidadoSave
                if ($pathinfo === '/api/Solicitud/validacionDatos/validado') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_validacionDatosvalidadoSave;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::validacionDatoValidadosAction',  '_route' => 'validacionDatosvalidadoSave',);
                }
                not_validacionDatosvalidadoSave:

                // ListaEspera
                if ($pathinfo === '/api/Solicitud/ListaEspera/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ListaEspera;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::updateEstatusNotListaesperaAction',  '_route' => 'ListaEspera',);
                }
                not_ListaEspera:

                // getAspiranteFoto
                if (rtrim($pathinfo, '/') === '/api/Solicitud/foto') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getAspiranteFoto;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'getAspiranteFoto');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::getAspiranteFoto',  '_route' => 'getAspiranteFoto',);
                }
                not_getAspiranteFoto:

            }

            // BuscarDatosImpresionById
            if (0 === strpos($pathinfo, '/api/reciboinscripcion/getdatosimpresion') && preg_match('#^/api/reciboinscripcion/getdatosimpresion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_BuscarDatosImpresionById;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarDatosImpresionById')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::BuscarDatosImpresionById',));
            }
            not_BuscarDatosImpresionById:

            // solicitudReporte
            if (0 === strpos($pathinfo, '/api/Solicitud/SolicitudReporte') && preg_match('#^/api/Solicitud/SolicitudReporte/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_solicitudReporte;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'solicitudReporte')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\SolicitudController::solicitudReporte',));
            }
            not_solicitudReporte:

            if (0 === strpos($pathinfo, '/api/Tablero')) {
                // tablero
                if ($pathinfo === '/api/Tablero') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_tablero;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::indexAction',  '_route' => 'tablero',);
                }
                not_tablero:

                // Configuraciones
                if ($pathinfo === '/api/Tablero/Configuraciones') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_Configuraciones;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::Configuraciones',  '_route' => 'Configuraciones',);
                }
                not_Configuraciones:

                // SolicitudAmision
                if ($pathinfo === '/api/Tablero/SolicitudAmision') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudAmision;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::SolicitudAmision',  '_route' => 'SolicitudAmision',);
                }
                not_SolicitudAmision:

                // Configuracion
                if (0 === strpos($pathinfo, '/api/Tablero/Configuracion') && preg_match('#^/api/Tablero/Configuracion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_Configuracion;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'Configuracion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::Configuracion',));
                }
                not_Configuracion:

                // vistaprevia
                if ($pathinfo === '/api/Tablero/vistaprevia') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_vistaprevia;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::vistaprevia',  '_route' => 'vistaprevia',);
                }
                not_vistaprevia:

                // copiar
                if ($pathinfo === '/api/Tablero/copiar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_copiar;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::copiar',  '_route' => 'copiar',);
                }
                not_copiar:

                // eliminarConfiguracion
                if (0 === strpos($pathinfo, '/api/Tablero/eliminarConfiguracion') && preg_match('#^/api/Tablero/eliminarConfiguracion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_eliminarConfiguracion;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarConfiguracion')), array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::eliminarConfiguracion',));
                }
                not_eliminarConfiguracion:

                // CrearConfiguracion
                if ($pathinfo === '/api/Tablero/CrearConfiguracion') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_CrearConfiguracion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::CrearConfiguracion',  '_route' => 'CrearConfiguracion',);
                }
                not_CrearConfiguracion:

                // EditarConfiguracion
                if ($pathinfo === '/api/Tablero/EditarConfiguracion') {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_EditarConfiguracion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admisiones\\TableroController::EditarConfiguracion',  '_route' => 'EditarConfiguracion',);
                }
                not_EditarConfiguracion:

            }

            if (0 === strpos($pathinfo, '/api/pago')) {
                // BBPagoInstitutoLux
                if ($pathinfo === '/api/pagoinstitutolux') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_BBPagoInstitutoLux;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\BancoBajioController::BBPagoInstitutoLux',  '_route' => 'BBPagoInstitutoLux',);
                }
                not_BBPagoInstitutoLux:

                if (0 === strpos($pathinfo, '/api/pagolinea')) {
                    // BBImprimirRecibo
                    if ($pathinfo === '/api/pagolinea/ImprimirRecibo') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_BBImprimirRecibo;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\PagoLineaController::BBImprimirRecibo',  '_route' => 'BBImprimirRecibo',);
                    }
                    not_BBImprimirRecibo:

                    // BBGetNextFolio
                    if ($pathinfo === '/api/pagolinea/getnextfolio') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BBGetNextFolio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\PagoLineaController::GetNextFolio',  '_route' => 'BBGetNextFolio',);
                    }
                    not_BBGetNextFolio:

                    // BBGetHashBancoBajio
                    if ($pathinfo === '/api/pagolinea/hash') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BBGetHashBancoBajio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\PagoLineaController::GetHashBancoBajio',  '_route' => 'BBGetHashBancoBajio',);
                    }
                    not_BBGetHashBancoBajio:

                    // BBRecibirPagoBancoBajio
                    if ($pathinfo === '/api/pagolinea/RecibirPago') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BBRecibirPagoBancoBajio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\PagoLineaController::RecibirPagoBancoBajio',  '_route' => 'BBRecibirPagoBancoBajio',);
                    }
                    not_BBRecibirPagoBancoBajio:

                    // BBHashBanco
                    if ($pathinfo === '/api/pagolinea/hashBanco') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BBHashBanco;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\BancoBajio\\PagoLineaController::HashBanco',  '_route' => 'BBHashBanco',);
                    }
                    not_BBHashBanco:

                }

            }

            if (0 === strpos($pathinfo, '/api/Aplicacionexamen')) {
                // BuscarAplicacionexamenLista
                if (0 === strpos($pathinfo, '/api/Aplicacionexamen/Lista') && preg_match('#^/api/Aplicacionexamen/Lista/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAplicacionexamenLista;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAplicacionexamenLista')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\AplicacionExamenController::indexAplicacionexamen',));
                }
                not_BuscarAplicacionexamenLista:

                // BuscarAplicacionexamenTiempo
                if (0 === strpos($pathinfo, '/api/Aplicacionexamen/Tiempo') && preg_match('#^/api/Aplicacionexamen/Tiempo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAplicacionexamenTiempo;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAplicacionexamenTiempo')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\AplicacionExamenController::tiempoAplicacionexamen',));
                }
                not_BuscarAplicacionexamenTiempo:

                // BuscarAplicacionexamenReactivos
                if ($pathinfo === '/api/Aplicacionexamen/Reactivos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAplicacionexamenReactivos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\AplicacionExamenController::getBuscarAplicacionexamenReactivos',  '_route' => 'BuscarAplicacionexamenReactivos',);
                }
                not_BuscarAplicacionexamenReactivos:

                // ActualizarAplicacioneexamen
                if ($pathinfo === '/api/Aplicacionexamen/Examen') {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarAplicacioneexamen;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\AplicacionExamenController::updateAplicacionExamen',  '_route' => 'ActualizarAplicacioneexamen',);
                }
                not_ActualizarAplicacioneexamen:

            }

            if (0 === strpos($pathinfo, '/api/Bancoreactivos')) {
                if (0 === strpos($pathinfo, '/api/Bancoreactivos/C')) {
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Cal')) {
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calendarizacionexamen')) {
                            // indexCalendarizacionexamen
                            if ($pathinfo === '/api/Bancoreactivos/Calendarizacionexamen') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexCalendarizacionexamen;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::indexCalendarizacionexamen',  '_route' => 'indexCalendarizacionexamen',);
                            }
                            not_indexCalendarizacionexamen:

                            // BuscarCalendarizacionexamen
                            if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Calendarizacionexamen') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalendarizacionexamen;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarCalendarizacionexamen');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getCalendarizacionexamen',  '_route' => 'BuscarCalendarizacionexamen',);
                            }
                            not_BuscarCalendarizacionexamen:

                            // EliminarCalendarizacionexamen
                            if (preg_match('#^/api/Bancoreactivos/Calendarizacionexamen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_EliminarCalendarizacionexamen;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCalendarizacionexamen')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::deleteCalendarizacionexamen',));
                            }
                            not_EliminarCalendarizacionexamen:

                            // BuscarCalendarizacionexamenExamen
                            if ($pathinfo === '/api/Bancoreactivos/Calendarizacionexamen/Examen') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalendarizacionexamenExamen;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getCalendarizacionexamenExamen',  '_route' => 'BuscarCalendarizacionexamenExamen',);
                            }
                            not_BuscarCalendarizacionexamenExamen:

                            // getAlumnosexamenaplicado
                            if ($pathinfo === '/api/Bancoreactivos/Calendarizacionexamen/VerificarAlumno') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getAlumnosexamenaplicado;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getAlumnosexamenaplicado',  '_route' => 'getAlumnosexamenaplicado',);
                            }
                            not_getAlumnosexamenaplicado:

                            // BuscarCalendarizacionAsignacion
                            if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calendarizacionexamen/Asignacion') && preg_match('#^/api/Bancoreactivos/Calendarizacionexamen/Asignacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalendarizacionAsignacion;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarCalendarizacionAsignacion')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getCalendarizacionexamenAsignacion',));
                            }
                            not_BuscarCalendarizacionAsignacion:

                            // getGruposCalendarizacion
                            if ($pathinfo === '/api/Bancoreactivos/Calendarizacionexamen/Grupos') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getGruposCalendarizacion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getGruposCalendarizacion',  '_route' => 'getGruposCalendarizacion',);
                            }
                            not_getGruposCalendarizacion:

                            // BuscarCalendarizacionexamenUsuario
                            if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calendarizacionexamen/Usuario') && preg_match('#^/api/Bancoreactivos/Calendarizacionexamen/Usuario/(?P<tipoaplicacion>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalendarizacionexamenUsuario;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarCalendarizacionexamenUsuario')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::getCalendarizacionexamenUsuario',));
                            }
                            not_BuscarCalendarizacionexamenUsuario:

                            // GuardarCalendarizacionexamen
                            if ($pathinfo === '/api/Bancoreactivos/Calendarizacionexamen') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardarCalendarizacionexamen;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::SaveCalendarizacionexamen',  '_route' => 'GuardarCalendarizacionexamen',);
                            }
                            not_GuardarCalendarizacionexamen:

                            // ActualizarCalendarizacionexamen
                            if (preg_match('#^/api/Bancoreactivos/Calendarizacionexamen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_ActualizarCalendarizacionexamen;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarCalendarizacionexamen')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalendarizacionExamenController::updateCalendarizacionexamen',));
                            }
                            not_ActualizarCalendarizacionexamen:

                        }

                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calificacionexamen')) {
                            // indexCalificacionExamen
                            if ($pathinfo === '/api/Bancoreactivos/Calificacionexamen') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexCalificacionExamen;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::indexCalificacionExamen',  '_route' => 'indexCalificacionExamen',);
                            }
                            not_indexCalificacionExamen:

                            // BuscarCalificacionExamen
                            if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Calificacionexamen') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalificacionExamen;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarCalificacionExamen');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::getCalificacionExamen',  '_route' => 'BuscarCalificacionExamen',);
                            }
                            not_BuscarCalificacionExamen:

                            // BuscarCalificacionExamenalumnos
                            if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calificacionexamen/Alumnos') && preg_match('#^/api/Bancoreactivos/Calificacionexamen/Alumnos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalificacionExamenalumnos;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarCalificacionExamenalumnos')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::getCalificacionExamenAlumnos',));
                            }
                            not_BuscarCalificacionExamenalumnos:

                            // BuscarCalificacionexamendetalle
                            if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calificacionexamen/Detalle') && preg_match('#^/api/Bancoreactivos/Calificacionexamen/Detalle/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarCalificacionexamendetalle;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarCalificacionexamendetalle')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::getCalificacionexamenDetalle',));
                            }
                            not_BuscarCalificacionexamendetalle:

                            // GuardarCalificacionexamen
                            if (preg_match('#^/api/Bancoreactivos/Calificacionexamen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardarCalificacionexamen;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarCalificacionexamen')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::SaveCalificacionexamen',));
                            }
                            not_GuardarCalificacionexamen:

                            if (0 === strpos($pathinfo, '/api/Bancoreactivos/Calificacionexamen/Gradecam')) {
                                // ReadCalificacionexamenGradecamArchvio
                                if (preg_match('#^/api/Bancoreactivos/Calificacionexamen/Gradecam/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_ReadCalificacionexamenGradecamArchvio;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ReadCalificacionexamenGradecamArchvio')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::readExamenesGradecamArchivo',));
                                }
                                not_ReadCalificacionexamenGradecamArchvio:

                                // updateCalificacionexamenGradecamArchvio
                                if (preg_match('#^/api/Bancoreactivos/Calificacionexamen/Gradecam/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_updateCalificacionexamenGradecamArchvio;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateCalificacionexamenGradecamArchvio')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\CalificacionExamenController::updateExamenesGradecamArchivo',));
                                }
                                not_updateCalificacionexamenGradecamArchvio:

                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Colegio')) {
                        // BuscarColegio
                        if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Colegio') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarColegio;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarColegio');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ColegiosController::indexPColegio',  '_route' => 'BuscarColegio',);
                        }
                        not_BuscarColegio:

                        // EliminarColegio
                        if (preg_match('#^/api/Bancoreactivos/Colegio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarColegio;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarColegio')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ColegiosController::deleteColegio',));
                        }
                        not_EliminarColegio:

                        // GuardarColegio
                        if ($pathinfo === '/api/Bancoreactivos/Colegio') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarColegio;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ColegiosController::SaveColegio',  '_route' => 'GuardarColegio',);
                        }
                        not_GuardarColegio:

                        // ActualizarColegio
                        if (preg_match('#^/api/Bancoreactivos/Colegio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarColegio;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarColegio')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ColegiosController::updateColegio',));
                        }
                        not_ActualizarColegio:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes')) {
                    // indexExamenes
                    if ($pathinfo === '/api/Bancoreactivos/Examenes') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexExamenes;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::indexExamenes',  '_route' => 'indexExamenes',);
                    }
                    not_indexExamenes:

                    // BuscarExamenes
                    if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Examenes') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarExamenes;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarExamenes');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::getExamenes',  '_route' => 'BuscarExamenes',);
                    }
                    not_BuscarExamenes:

                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Configuracion')) {
                        // GuardarExamenesConfiguracion
                        if ($pathinfo === '/api/Bancoreactivos/Examenes/Configuracion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarExamenesConfiguracion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::saveExamenesConfiguracion',  '_route' => 'GuardarExamenesConfiguracion',);
                        }
                        not_GuardarExamenesConfiguracion:

                        // ActualizarExamenesConfiguracion
                        if (preg_match('#^/api/Bancoreactivos/Examenes/Configuracion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarExamenesConfiguracion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarExamenesConfiguracion')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::updateExamenesConfiguracion',));
                        }
                        not_ActualizarExamenesConfiguracion:

                    }

                    // BuscarMultimediaExamenesContenido
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Multimedia') && preg_match('#^/api/Bancoreactivos/Examenes/Multimedia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarMultimediaExamenesContenido;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarMultimediaExamenesContenido')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::getMultimediaContenido',));
                    }
                    not_BuscarMultimediaExamenesContenido:

                    // ActualizarExamenesContenido
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Contenido') && preg_match('#^/api/Bancoreactivos/Examenes/Contenido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarExamenesContenido;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarExamenesContenido')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::updateExamenesContenido',));
                    }
                    not_ActualizarExamenesContenido:

                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Reactivos')) {
                        // BuscarExamenesReactivos
                        if (preg_match('#^/api/Bancoreactivos/Examenes/Reactivos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarExamenesReactivos;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarExamenesReactivos')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::getReactivos',));
                        }
                        not_BuscarExamenesReactivos:

                        // ActualizarExamenesReactivosasignados
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Reactivosasignados') && preg_match('#^/api/Bancoreactivos/Examenes/Reactivosasignados/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarExamenesReactivosasignados;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarExamenesReactivosasignados')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::updateExamenesReactivosasignados',));
                        }
                        not_ActualizarExamenesReactivosasignados:

                        // ActualizarExamenesReactivosdisponibles
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Reactivosdisponibles') && preg_match('#^/api/Bancoreactivos/Examenes/Reactivosdisponibles/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarExamenesReactivosdisponibles;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarExamenesReactivosdisponibles')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::updateExamenesReactivosdisponibles',));
                        }
                        not_ActualizarExamenesReactivosdisponibles:

                    }

                    // BuscarExamenesEspecificaciones
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Especificaciones') && preg_match('#^/api/Bancoreactivos/Examenes/Especificaciones/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarExamenesEspecificaciones;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarExamenesEspecificaciones')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::getExamenesEspecificaciones',));
                    }
                    not_BuscarExamenesEspecificaciones:

                    // CopiaExamenes
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Examenes/Copia') && preg_match('#^/api/Bancoreactivos/Examenes/Copia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_CopiaExamenes;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'CopiaExamenes')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::copiaExamenes',));
                    }
                    not_CopiaExamenes:

                    // EliminarExamenes
                    if (preg_match('#^/api/Bancoreactivos/Examenes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarExamenes;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarExamenes')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ExamenController::deletePais',));
                    }
                    not_EliminarExamenes:

                }

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivo')) {
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos')) {
                        // indexReactivos
                        if ($pathinfo === '/api/Bancoreactivos/Reactivos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexReactivos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::indexReactivo',  '_route' => 'indexReactivos',);
                        }
                        not_indexReactivos:

                        // BuscarReactivos
                        if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Reactivos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarReactivos;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarReactivos');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getReactivos',  '_route' => 'BuscarReactivos',);
                        }
                        not_BuscarReactivos:

                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Configuracion')) {
                            // GuardarReactivoConfiguracion
                            if ($pathinfo === '/api/Bancoreactivos/Reactivos/Configuracion') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardarReactivoConfiguracion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::saveReactivoConfiguracion',  '_route' => 'GuardarReactivoConfiguracion',);
                            }
                            not_GuardarReactivoConfiguracion:

                            // ActualizarReactivoConfiguracion
                            if (preg_match('#^/api/Bancoreactivos/Reactivos/Configuracion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_ActualizarReactivoConfiguracion;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarReactivoConfiguracion')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::updateReactivoConfiguracion',));
                            }
                            not_ActualizarReactivoConfiguracion:

                        }

                        // BuscarMultimediaReactivosContenido
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Multimedia') && preg_match('#^/api/Bancoreactivos/Reactivos/Multimedia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarMultimediaReactivosContenido;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarMultimediaReactivosContenido')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getMultimediaContenido',));
                        }
                        not_BuscarMultimediaReactivosContenido:

                        // ActualizarReactivoContenido
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Contenido') && preg_match('#^/api/Bancoreactivos/Reactivos/Contenido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarReactivoContenido;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarReactivoContenido')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::updateReactivoContenido',));
                        }
                        not_ActualizarReactivoContenido:

                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Respuesta')) {
                            // BuscarRespuesta
                            if (preg_match('#^/api/Bancoreactivos/Reactivos/Respuesta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarRespuesta;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarRespuesta')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getReactivoRespuesta',));
                            }
                            not_BuscarRespuesta:

                            // ActualizarReactivoRespuestas
                            if (preg_match('#^/api/Bancoreactivos/Reactivos/Respuesta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_ActualizarReactivoRespuestas;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarReactivoRespuestas')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::updateReactivoRespuestas',));
                            }
                            not_ActualizarReactivoRespuestas:

                        }

                        // ActualizarReactivoEstandarizacion
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Estandarizacion') && preg_match('#^/api/Bancoreactivos/Reactivos/Estandarizacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarReactivoEstandarizacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarReactivoEstandarizacion')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::updateReactivoEstandarizacion',));
                        }
                        not_ActualizarReactivoEstandarizacion:

                        // BuscarReactivosBitacora
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Bitacora') && preg_match('#^/api/Bancoreactivos/Reactivos/Bitacora/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarReactivosBitacora;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarReactivosBitacora')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getBitacora',));
                        }
                        not_BuscarReactivosBitacora:

                        // ActualizarReactivoEstatus
                        if ($pathinfo === '/api/Bancoreactivos/Reactivos/Estatus') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarReactivoEstatus;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::updateReactivoEstatus',  '_route' => 'ActualizarReactivoEstatus',);
                        }
                        not_ActualizarReactivoEstatus:

                    }

                    // EliminarReactivo
                    if (preg_match('#^/api/Bancoreactivos/Reactivo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarReactivo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarReactivo')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::deleteReactivo',));
                    }
                    not_EliminarReactivo:

                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos')) {
                        // BuscarExamenReactivosConfiguracion
                        if (0 === strpos($pathinfo, '/api/Bancoreactivos/Reactivos/Examen') && preg_match('#^/api/Bancoreactivos/Reactivos/Examen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarExamenReactivosConfiguracion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarExamenReactivosConfiguracion')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getExamenReactivo',));
                        }
                        not_BuscarExamenReactivosConfiguracion:

                        // BuscarReactivoPreview
                        if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Reactivos/Preview') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarReactivoPreview;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarReactivoPreview');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosController::getPreview',  '_route' => 'BuscarReactivoPreview',);
                        }
                        not_BuscarReactivoPreview:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Generalresultados')) {
                    // indexGeneralresultados
                    if ($pathinfo === '/api/Bancoreactivos/Generalresultados') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexGeneralresultados;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosResultadosGeneralController::indexGeneralresultados',  '_route' => 'indexGeneralresultados',);
                    }
                    not_indexGeneralresultados:

                    // BuscarGeneralresultados
                    if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Generalresultados') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarGeneralresultados;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarGeneralresultados');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosResultadosGeneralController::getGeneralresultados',  '_route' => 'BuscarGeneralresultados',);
                    }
                    not_BuscarGeneralresultados:

                    // BuscarGeneralresultadosdetalle
                    if (0 === strpos($pathinfo, '/api/Bancoreactivos/Generalresultados/Detalle') && preg_match('#^/api/Bancoreactivos/Generalresultados/Detalle/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarGeneralresultadosdetalle;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarGeneralresultadosdetalle')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosResultadosGeneralController::getGeneralresultadosDetalle',));
                    }
                    not_BuscarGeneralresultadosdetalle:

                }

                // indexResultadosporrectivoTest
                if ($pathinfo === '/api/Bancoreactivos/Resultadosporrectivo') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexResultadosporrectivoTest;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\ReactivosResultadosGeneralController::indexResultadosPorRectivo',  '_route' => 'indexResultadosporrectivoTest',);
                }
                not_indexResultadosporrectivoTest:

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Subtema')) {
                    // indexSubtema
                    if ($pathinfo === '/api/Bancoreactivos/Subtema') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexSubtema;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\SubtemaController::indexSubtema',  '_route' => 'indexSubtema',);
                    }
                    not_indexSubtema:

                    // BuscarSubtema
                    if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Subtema') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarSubtema;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarSubtema');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\SubtemaController::getTema',  '_route' => 'BuscarSubtema',);
                    }
                    not_BuscarSubtema:

                    // EliminarSubtema
                    if (preg_match('#^/api/Bancoreactivos/Subtema/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarSubtema;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarSubtema')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\SubtemaController::deleteTema',));
                    }
                    not_EliminarSubtema:

                    // GuardarSubtema
                    if ($pathinfo === '/api/Bancoreactivos/Subtema') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarSubtema;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\SubtemaController::SaveTema',  '_route' => 'GuardarSubtema',);
                    }
                    not_GuardarSubtema:

                    // ActualizarSubtema
                    if (preg_match('#^/api/Bancoreactivos/Subtema/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarSubtema;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarSubtema')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\SubtemaController::updateSubtema',));
                    }
                    not_ActualizarSubtema:

                }

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Tema')) {
                    // indexTema
                    if ($pathinfo === '/api/Bancoreactivos/Tema') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexTema;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\TemaController::indexTema',  '_route' => 'indexTema',);
                    }
                    not_indexTema:

                    // BuscarTema
                    if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Tema') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarTema;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarTema');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\TemaController::getTema',  '_route' => 'BuscarTema',);
                    }
                    not_BuscarTema:

                    // EliminarTema
                    if (preg_match('#^/api/Bancoreactivos/Tema/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarTema;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarTema')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\TemaController::deleteTema',));
                    }
                    not_EliminarTema:

                    // GuardarTema
                    if ($pathinfo === '/api/Bancoreactivos/Tema') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarTema;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\TemaController::SaveTema',  '_route' => 'GuardarTema',);
                    }
                    not_GuardarTema:

                    // ActualizarTema
                    if (preg_match('#^/api/Bancoreactivos/Tema/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarTema;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarTema')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\TemaController::updateTema',));
                    }
                    not_ActualizarTema:

                }

                if (0 === strpos($pathinfo, '/api/Bancoreactivos/Usuarioexterno')) {
                    // inicioUsuarioexterno
                    if ($pathinfo === '/api/Bancoreactivos/Usuarioexterno') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_inicioUsuarioexterno;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::indexUsuarioexterno',  '_route' => 'inicioUsuarioexterno',);
                    }
                    not_inicioUsuarioexterno:

                    // BuscarUsuarioexterno
                    if (rtrim($pathinfo, '/') === '/api/Bancoreactivos/Usuarioexterno') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarUsuarioexterno;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarUsuarioexterno');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::getUsuarioexterno',  '_route' => 'BuscarUsuarioexterno',);
                    }
                    not_BuscarUsuarioexterno:

                    // EliminarUsuarioexterno
                    if (preg_match('#^/api/Bancoreactivos/Usuarioexterno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarUsuarioexterno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarUsuarioexterno')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::deleteUsuarioexterno',));
                    }
                    not_EliminarUsuarioexterno:

                    // GuardarUsuarioexterno
                    if ($pathinfo === '/api/Bancoreactivos/Usuarioexterno') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarUsuarioexterno;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::SaveUsuarioexterno',  '_route' => 'GuardarUsuarioexterno',);
                    }
                    not_GuardarUsuarioexterno:

                    // ActualizarUsuarioexterno
                    if (preg_match('#^/api/Bancoreactivos/Usuarioexterno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarUsuarioexterno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarUsuarioexterno')), array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::updateUsuarioexterno',));
                    }
                    not_ActualizarUsuarioexterno:

                    // downloadLayoutUsuarios
                    if ($pathinfo === '/api/Bancoreactivos/Usuarioexterno/Descargar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_downloadLayoutUsuarios;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::downloadLayoutUsuarios',  '_route' => 'downloadLayoutUsuarios',);
                    }
                    not_downloadLayoutUsuarios:

                    // importarLayoutUsuarios
                    if ($pathinfo === '/api/Bancoreactivos/Usuarioexterno/Importar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_importarLayoutUsuarios;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Bancoreactivo\\UsuarioExternoController::importarLayoutUsuarios',  '_route' => 'importarLayoutUsuarios',);
                    }
                    not_importarLayoutUsuarios:

                }

            }

            // IndexAlumnoTemporal
            if (rtrim($pathinfo, '/') === '/api/Altaalumno') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_IndexAlumnoTemporal;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'IndexAlumnoTemporal');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\AltaAlumnosController::IndexAlumnoTemporal',  '_route' => 'IndexAlumnoTemporal',);
            }
            not_IndexAlumnoTemporal:

            if (0 === strpos($pathinfo, '/api/Becas/Altaalumno')) {
                // GuardarAlumnoTemporal
                if ($pathinfo === '/api/Becas/Altaalumno') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarAlumnoTemporal;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\AltaAlumnosController::GuardarAlumnoTemporal',  '_route' => 'GuardarAlumnoTemporal',);
                }
                not_GuardarAlumnoTemporal:

                // deleteAlumnotemporal
                if ($pathinfo === '/api/Becas/Altaalumno/Eliminar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_deleteAlumnotemporal;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\AltaAlumnosController::deleteAlumnotemporal',  '_route' => 'deleteAlumnotemporal',);
                }
                not_deleteAlumnotemporal:

            }

            if (0 === strpos($pathinfo, '/api/ConsultaBecas')) {
                // ConsultaBecasIndex
                if ($pathinfo === '/api/ConsultaBecas') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ConsultaBecasIndex;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\BecaController::Index',  '_route' => 'ConsultaBecasIndex',);
                }
                not_ConsultaBecasIndex:

                // becasfiltro
                if ($pathinfo === '/api/ConsultaBecas/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_becasfiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\BecaController::becasfiltro',  '_route' => 'becasfiltro',);
                }
                not_becasfiltro:

                // Guardarbecas
                if ($pathinfo === '/api/ConsultaBecas/Beca') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_Guardarbecas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\BecaController::Guardarbecas',  '_route' => 'Guardarbecas',);
                }
                not_Guardarbecas:

                // cancelarbeca
                if ($pathinfo === '/api/ConsultaBecas/Cancelar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_cancelarbeca;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\BecaController::Cancelarbeca',  '_route' => 'cancelarbeca',);
                }
                not_cancelarbeca:

                // ActualizarBecas
                if (0 === strpos($pathinfo, '/api/ConsultaBecas/Beca') && preg_match('#^/api/ConsultaBecas/Beca/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ActualizarBecas;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarBecas')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\BecaController::ActualizarBecas',));
                }
                not_ActualizarBecas:

            }

            if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos')) {
                // ObtenerDependientesEconomicos
                if (preg_match('#^/api/Becas/SolicitudBeca/DependientesEconomicos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ObtenerDependientesEconomicos;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerDependientesEconomicos')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::ObtenerDependientesEconomicos',));
                }
                not_ObtenerDependientesEconomicos:

                // ObtenerHijos
                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerHijos') && preg_match('#^/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerHijos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ObtenerHijos;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerHijos')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::ObtenerHijos',));
                }
                not_ObtenerHijos:

                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/Hijos')) {
                    // GuardaoEditaHijos
                    if ($pathinfo === '/api/Becas/SolicitudBeca/DependientesEconomicos/Hijos') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardaoEditaHijos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::GuardaoEditaHijos',  '_route' => 'GuardaoEditaHijos',);
                    }
                    not_GuardaoEditaHijos:

                    // EliminarHijos
                    if (preg_match('#^/api/Becas/SolicitudBeca/DependientesEconomicos/Hijos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarHijos;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarHijos')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::EliminarHijos',));
                    }
                    not_EliminarHijos:

                }

                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/O')) {
                    // ObtenerOtrosDependientes
                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerOtrosDependientes') && preg_match('#^/api/Becas/SolicitudBeca/DependientesEconomicos/ObtenerOtrosDependientes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ObtenerOtrosDependientes;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerOtrosDependientes')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::ObtenerOtrosDependientes',));
                    }
                    not_ObtenerOtrosDependientes:

                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/Otros')) {
                        // OtrosDependientes
                        if ($pathinfo === '/api/Becas/SolicitudBeca/DependientesEconomicos/OtrosDependientes') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_OtrosDependientes;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::OtrosDependientes',  '_route' => 'OtrosDependientes',);
                        }
                        not_OtrosDependientes:

                        // EliminarOtrosdependienteseconomicos
                        if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/DependientesEconomicos/Otrosdependienteseconomicos') && preg_match('#^/api/Becas/SolicitudBeca/DependientesEconomicos/Otrosdependienteseconomicos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarOtrosdependienteseconomicos;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarOtrosdependienteseconomicos')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DependientesEconomicosController::EliminarOtrosdependienteseconomicos',));
                        }
                        not_EliminarOtrosdependienteseconomicos:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/SolicitudBeca')) {
                // newbecas
                if ($pathinfo === '/api/SolicitudBeca/becaprovisional') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_newbecas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::newbecas',  '_route' => 'newbecas',);
                }
                not_newbecas:

                // edicionbecap
                if (0 === strpos($pathinfo, '/api/SolicitudBeca/edicionbecapro') && preg_match('#^/api/SolicitudBeca/edicionbecapro/(?P<provicionalid>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_edicionbecap;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'edicionbecap')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::edicionbecap',));
                }
                not_edicionbecap:

                // Actualizarbecaprovisional
                if (0 === strpos($pathinfo, '/api/SolicitudBeca/Actualizarbecaprovisional') && preg_match('#^/api/SolicitudBeca/Actualizarbecaprovisional/(?P<idbecaprovisional>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_Actualizarbecaprovisional;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'Actualizarbecaprovisional')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::Actualizarbecaprovisional',));
                }
                not_Actualizarbecaprovisional:

                // actualizarEstatusBeca
                if ($pathinfo === '/api/SolicitudBeca/actualizarEstatus/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_actualizarEstatusBeca;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::actualizarEstatusBeca',  '_route' => 'actualizarEstatusBeca',);
                }
                not_actualizarEstatusBeca:

                // deletebeca
                if (0 === strpos($pathinfo, '/api/SolicitudBeca/eliminarbeca') && preg_match('#^/api/SolicitudBeca/eliminarbeca/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_deletebeca;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletebeca')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::deletebeca',));
                }
                not_deletebeca:

                // dictaminarsolicitud
                if ($pathinfo === '/api/SolicitudBeca/dictaminar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_dictaminarsolicitud;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::dictaminarsolicitud',  '_route' => 'dictaminarsolicitud',);
                }
                not_dictaminarsolicitud:

                // bnuevas
                if ($pathinfo === '/api/SolicitudBeca/nuevasbecas') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_bnuevas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\DictaminarController::bnuevas',  '_route' => 'bnuevas',);
                }
                not_bnuevas:

                // solicitudhijos
                if ($pathinfo === '/api/SolicitudBeca/solicitudbecahijos') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_solicitudhijos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::solicitudhijos',  '_route' => 'solicitudhijos',);
                }
                not_solicitudhijos:

            }

            if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca')) {
                // ObtenerInformacionFamiliar
                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerInformacionFamiliar') && preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerInformacionFamiliar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ObtenerInformacionFamiliar;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerInformacionFamiliar')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::ObtenerInformacionFamiliar',));
                }
                not_ObtenerInformacionFamiliar:

                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/ArchivoSE')) {
                    // GuardarArchivoSE
                    if ($pathinfo === '/api/Becas/SolicitudBeca/ArchivoSE') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarArchivoSE;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::GuardarArchivoSE',  '_route' => 'GuardarArchivoSE',);
                    }
                    not_GuardarArchivoSE:

                    // DescargarArchivoSE
                    if (preg_match('#^/api/Becas/SolicitudBeca/ArchivoSE/(?P<solicitudid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DescargarArchivoSE;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarArchivoSE')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::DescargarArchivoSE',));
                    }
                    not_DescargarArchivoSE:

                }

            }

            // becarecomendada
            if ($pathinfo === '/api/SolicitudBeca/GuardarBecaRecomendada') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_becarecomendada;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::becarecomendada',  '_route' => 'becarecomendada',);
            }
            not_becarecomendada:

            // GuardarEstudiose
            if ($pathinfo === '/api/Becas/SolicitudBeca/Estudiose') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_GuardarEstudiose;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::GuardarEstudiose',  '_route' => 'GuardarEstudiose',);
            }
            not_GuardarEstudiose:

            // cambiarstatussolicitud
            if ($pathinfo === '/api/SolicitudBeca/estatus/cambiar') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_cambiarstatussolicitud;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::cambiarstatussolicitud',  '_route' => 'cambiarstatussolicitud',);
            }
            not_cambiarstatussolicitud:

            // importarlayaoutestudiose
            if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica/importarlayaoutestudiose') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_importarlayaoutestudiose;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\EstudioSocioeconomicoController::importarlayaoutestudiose',  '_route' => 'importarlayaoutestudiose',);
            }
            not_importarlayaoutestudiose:

            // BecaPadresoTutoresIndex
            if ($pathinfo === '/api/SolicitudBeca/estadocivil') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_BecaPadresoTutoresIndex;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\PadresController::indexBecaPadresOTutores',  '_route' => 'BecaPadresoTutoresIndex',);
            }
            not_BecaPadresoTutoresIndex:

            // getBecaPadresoTutores
            if (0 === strpos($pathinfo, '/api/Becas/PadresOTutoresAlumno') && preg_match('#^/api/Becas/PadresOTutoresAlumno/(?P<solicitudid>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_getBecaPadresoTutores;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getBecaPadresoTutores')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\PadresController::getBecaPadresoTutores',));
            }
            not_getBecaPadresoTutores:

            if (0 === strpos($pathinfo, '/api/SolicitudBeca')) {
                // BecaPadresoTutoresGuardar
                if ($pathinfo === '/api/SolicitudBeca/GuardarPadrestutores') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_BecaPadresoTutoresGuardar;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\PadresController::saveBecaPadresoTutores',  '_route' => 'BecaPadresoTutoresGuardar',);
                }
                not_BecaPadresoTutoresGuardar:

                // getaddres
                if ($pathinfo === '/api/SolicitudBeca/getdomicilio') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_getaddres;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::getaddres',  '_route' => 'getaddres',);
                }
                not_getaddres:

            }

            // ConsultaSolicitudBecasDocumentos
            if ($pathinfo === '/api/Becas/SolicitudBeca/Documentos') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_ConsultaSolicitudBecasDocumentos;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::ConsultaSolicitudBecasDocumentos',  '_route' => 'ConsultaSolicitudBecasDocumentos',);
            }
            not_ConsultaSolicitudBecasDocumentos:

            // obtenerdocs
            if ($pathinfo === '/api/SolicitudBeca/getdoc') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_obtenerdocs;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::obtenerdocs',  '_route' => 'obtenerdocs',);
            }
            not_obtenerdocs:

            // SolicitudBecasDocumentosGuardar
            if ($pathinfo === '/api/Becas/SolicitudBeca/Documentos/Guardar') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_SolicitudBecasDocumentosGuardar;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::SolicitudBecasDocumentosGuardar',  '_route' => 'SolicitudBecasDocumentosGuardar',);
            }
            not_SolicitudBecasDocumentosGuardar:

            // BecasRecepcionDocumentosGuardar
            if ($pathinfo === '/api/SolicitudBeca/documentosrecibido') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_BecasRecepcionDocumentosGuardar;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::saveBecasRecepcionDocumentos',  '_route' => 'BecasRecepcionDocumentosGuardar',);
            }
            not_BecasRecepcionDocumentosGuardar:

            if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca')) {
                // ReporteSolicitudBeca
                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/Reporte') && preg_match('#^/api/Becas/SolicitudBeca/Reporte/(?P<solicitudid>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ReporteSolicitudBeca;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ReporteSolicitudBeca')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\RecibirDocumentosController::ReporteSolicitudBeca',));
                }
                not_ReporteSolicitudBeca:

                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica')) {
                    // obtenerEgresonMensuales
                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/EgresosMensuales') && preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/EgresosMensuales/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_obtenerEgresonMensuales;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'obtenerEgresonMensuales')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::obtenerEgresonMensuales',));
                    }
                    not_obtenerEgresonMensuales:

                    // ObtenerSituacionEconomica
                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerSituacionEconomica') && preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/ObtenerSituacionEconomica/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ObtenerSituacionEconomica;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerSituacionEconomica')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::ObtenerSituacionEconomica',));
                    }
                    not_ObtenerSituacionEconomica:

                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos')) {
                        // GuardarDeudasCreditos
                        if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarDeudasCreditos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::GuardarDeudasCreditos',  '_route' => 'GuardarDeudasCreditos',);
                        }
                        not_GuardarDeudasCreditos:

                        // EliminarDeudasCreditos
                        if (preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/DeudasCreditos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarDeudasCreditos;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarDeudasCreditos')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::EliminarDeudasCreditos',));
                        }
                        not_EliminarDeudasCreditos:

                    }

                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares')) {
                        // GuardarPropiedadesfamiliares
                        if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarPropiedadesfamiliares;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::GuardarPropiedadesfamiliares',  '_route' => 'GuardarPropiedadesfamiliares',);
                        }
                        not_GuardarPropiedadesfamiliares:

                        // EliminarPropiedadesfamiliares
                        if (preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/Propiedadesfamiliares/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarPropiedadesfamiliares;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPropiedadesfamiliares')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::EliminarPropiedadesfamiliares',));
                        }
                        not_EliminarPropiedadesfamiliares:

                    }

                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/Vehiculo')) {
                        // GuardarVehiculos
                        if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica/Vehiculos') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarVehiculos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::GuardarVehiculos',  '_route' => 'GuardarVehiculos',);
                        }
                        not_GuardarVehiculos:

                        // EliminarVehiculo
                        if (preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/Vehiculo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarVehiculo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarVehiculo')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::EliminarVehiculo',));
                        }
                        not_EliminarVehiculo:

                    }

                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/SituacionEconomica/CuentaBanco')) {
                        // guardarCuentaBanco
                        if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica/CuentaBanco') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_guardarCuentaBanco;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::guardarCuentaBanco',  '_route' => 'guardarCuentaBanco',);
                        }
                        not_guardarCuentaBanco:

                        // eliminarCuentaBanco
                        if (preg_match('#^/api/Becas/SolicitudBeca/SituacionEconomica/CuentaBanco/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_eliminarCuentaBanco;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarCuentaBanco')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::eliminarCuentaBanco',));
                        }
                        not_eliminarCuentaBanco:

                    }

                    // GuardaoEditaSituacionEconomica
                    if ($pathinfo === '/api/Becas/SolicitudBeca/SituacionEconomica') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardaoEditaSituacionEconomica;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::GuardaoEditaSituacionEconomica',  '_route' => 'GuardaoEditaSituacionEconomica',);
                    }
                    not_GuardaoEditaSituacionEconomica:

                }

            }

            if (0 === strpos($pathinfo, '/api/SolicitudBeca')) {
                if (0 === strpos($pathinfo, '/api/SolicitudBeca/G')) {
                    // getReferenciasBecas
                    if ($pathinfo === '/api/SolicitudBeca/Getreferencias') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_getReferenciasBecas;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::getReferencias',  '_route' => 'getReferenciasBecas',);
                    }
                    not_getReferenciasBecas:

                    // referenciassolicitudbeca
                    if ($pathinfo === '/api/SolicitudBeca/GuardarReferencias') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_referenciassolicitudbeca;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::referenciassolicitudbeca',  '_route' => 'referenciassolicitudbeca',);
                    }
                    not_referenciassolicitudbeca:

                }

                // deleteReferencia
                if (0 === strpos($pathinfo, '/api/SolicitudBeca/eliminarRef') && preg_match('#^/api/SolicitudBeca/eliminarRef/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_deleteReferencia;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteReferencia')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::deleteReferencia',));
                }
                not_deleteReferencia:

                // getVisitaBecas
                if ($pathinfo === '/api/SolicitudBeca/getvisita') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_getVisitaBecas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::getVisita',  '_route' => 'getVisitaBecas',);
                }
                not_getVisitaBecas:

            }

            // DescargarFormatoBecaReglamento
            if (0 === strpos($pathinfo, '/api/Becas/PeriodoBeca/formato/descargar/reglamento') && preg_match('#^/api/Becas/PeriodoBeca/formato/descargar/reglamento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_DescargarFormatoBecaReglamento;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarFormatoBecaReglamento')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::DescargarFormatoBecaReglamento',));
            }
            not_DescargarFormatoBecaReglamento:

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                // SolicitudDownloadFormatoSolicitudBeca
                if (rtrim($pathinfo, '/') === '/api/Solicitud/DownloadFormatoSolicitudBeca') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudDownloadFormatoSolicitudBeca;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'SolicitudDownloadFormatoSolicitudBeca');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::solicitudDownloadFormatoSolicitudBeca',  '_route' => 'SolicitudDownloadFormatoSolicitudBeca',);
                }
                not_SolicitudDownloadFormatoSolicitudBeca:

                if (0 === strpos($pathinfo, '/api/SolicitudBeca')) {
                    // visitasocioeconomico
                    if ($pathinfo === '/api/SolicitudBeca/visitaestudios') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_visitasocioeconomico;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SituacionEconomicaController::visitasocioeconomico',  '_route' => 'visitasocioeconomico',);
                    }
                    not_visitasocioeconomico:

                    if (0 === strpos($pathinfo, '/api/SolicitudBeca/getdomicilio')) {
                        // SolicitudBecaDomicilioBuscar
                        if ($pathinfo === '/api/SolicitudBeca/getdomicilio') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_SolicitudBecaDomicilioBuscar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SolicitudController::getSolicitudBecaDomicilio',  '_route' => 'SolicitudBecaDomicilioBuscar',);
                        }
                        not_SolicitudBecaDomicilioBuscar:

                        // SolicitudBecaDomicilioAlumnoBuscar
                        if ($pathinfo === '/api/SolicitudBeca/getdomicilioalumno') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_SolicitudBecaDomicilioAlumnoBuscar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SolicitudController::getSolicitudBecaDomicilioAlumno',  '_route' => 'SolicitudBecaDomicilioAlumnoBuscar',);
                        }
                        not_SolicitudBecaDomicilioAlumnoBuscar:

                    }

                    // SolicitudBecaDomicilioGuardar
                    if ($pathinfo === '/api/SolicitudBeca/domicilio') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SolicitudBecaDomicilioGuardar;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\Modal\\SolicitudController::saveSolicitudBecaDomicilio',  '_route' => 'SolicitudBecaDomicilioGuardar',);
                    }
                    not_SolicitudBecaDomicilioGuardar:

                }

            }

            if (0 === strpos($pathinfo, '/api/Becas')) {
                if (0 === strpos($pathinfo, '/api/Becas/Periodo')) {
                    if (0 === strpos($pathinfo, '/api/Becas/Periodos')) {
                        // indexBecasPeriodos
                        if ($pathinfo === '/api/Becas/Periodos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexBecasPeriodos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::indexBecasPeriodos',  '_route' => 'indexBecasPeriodos',);
                        }
                        not_indexBecasPeriodos:

                        // periodobecasfiltrar
                        if ($pathinfo === '/api/Becas/PeriodosBecas/Filtrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_periodobecasfiltrar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::periodobecasfiltrar',  '_route' => 'periodobecasfiltrar',);
                        }
                        not_periodobecasfiltrar:

                    }

                    if (0 === strpos($pathinfo, '/api/Becas/PeriodoBeca')) {
                        // GuardarPeriodoBeca
                        if ($pathinfo === '/api/Becas/PeriodoBeca') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarPeriodoBeca;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::GuardarPeriodoBeca',  '_route' => 'GuardarPeriodoBeca',);
                        }
                        not_GuardarPeriodoBeca:

                        // ActualizarPeriodoBeca
                        if (preg_match('#^/api/Becas/PeriodoBeca/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarPeriodoBeca;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarPeriodoBeca')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::ActualizarPeriodoBeca',));
                        }
                        not_ActualizarPeriodoBeca:

                        // EliminarPeriodoBeca
                        if (preg_match('#^/api/Becas/PeriodoBeca/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarPeriodoBeca;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPeriodoBeca')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::EliminarPeriodoBeca',));
                        }
                        not_EliminarPeriodoBeca:

                        // DescargarFormatoBeca
                        if (0 === strpos($pathinfo, '/api/Becas/PeriodoBeca/formato/descargar') && preg_match('#^/api/Becas/PeriodoBeca/formato/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_DescargarFormatoBeca;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarFormatoBeca')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\PeriodosBecasController::DescargarFormatoBeca',));
                        }
                        not_DescargarFormatoBeca:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca')) {
                    // obtenerPeriodoCaptura
                    if ($pathinfo === '/api/Becas/SolicitudBeca/PeriodoCaptura') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_obtenerPeriodoCaptura;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::obtenerPeriodoCaptura',  '_route' => 'obtenerPeriodoCaptura',);
                    }
                    not_obtenerPeriodoCaptura:

                    // obtenerSolicitudesPadreoTutor
                    if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/padresotutores') && preg_match('#^/api/Becas/SolicitudBeca/padresotutores/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_obtenerSolicitudesPadreoTutor;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'obtenerSolicitudesPadreoTutor')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::obtenerSolicitudesPadreoTutor',));
                    }
                    not_obtenerSolicitudesPadreoTutor:

                }

            }

            // GuardarSolicitud
            if ($pathinfo === '/api/SolicitudBeca/GuardarSb') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_GuardarSolicitud;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::GuardarSolicitud',  '_route' => 'GuardarSolicitud',);
            }
            not_GuardarSolicitud:

            if (0 === strpos($pathinfo, '/api/ConsultaSolicitudBecas')) {
                // ConsultaSolicitudBecasIndex
                if ($pathinfo === '/api/ConsultaSolicitudBecas') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ConsultaSolicitudBecasIndex;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::Index',  '_route' => 'ConsultaSolicitudBecasIndex',);
                }
                not_ConsultaSolicitudBecasIndex:

                // ConsultaSolicitudBecasfiltro
                if ($pathinfo === '/api/ConsultaSolicitudBecas/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ConsultaSolicitudBecasfiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::ConsultaSolicitudBecasfiltro',  '_route' => 'ConsultaSolicitudBecasfiltro',);
                }
                not_ConsultaSolicitudBecasfiltro:

                // ConsultaSolicitudBecasDictaminacionfiltro
                if ($pathinfo === '/api/ConsultaSolicitudBecas/DictaminacionFiltrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ConsultaSolicitudBecasDictaminacionfiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::ConsultaSolicitudBecasDictaminacionfiltro',  '_route' => 'ConsultaSolicitudBecasDictaminacionfiltro',);
                }
                not_ConsultaSolicitudBecasDictaminacionfiltro:

            }

            // SolicitudBecaPago
            if ($pathinfo === '/api/SolicitudBeca/Pago') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_SolicitudBecaPago;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::SolicitudBecaPago',  '_route' => 'SolicitudBecaPago',);
            }
            not_SolicitudBecaPago:

            // InforFamiliaBeca
            if ($pathinfo === '/api/ConsultaSolicitudBecas/InfoFamiliaBeca') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_InforFamiliaBeca;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::InforFamiliaBeca',  '_route' => 'InforFamiliaBeca',);
            }
            not_InforFamiliaBeca:

            // SolicitudporalumnoGuardar
            if ($pathinfo === '/api/SolicitudBeca/GuardarSporalumno') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_SolicitudporalumnoGuardar;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::SolicitudporalumnoGuardar',  '_route' => 'SolicitudporalumnoGuardar',);
            }
            not_SolicitudporalumnoGuardar:

            if (0 === strpos($pathinfo, '/api/Becas/SolicitudBeca/Dictaminacion')) {
                // DescargaLayoutDictaminacionBeca
                if (rtrim($pathinfo, '/') === '/api/Becas/SolicitudBeca/Dictaminacion/DescargaLayoutDictaminacionBeca') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_DescargaLayoutDictaminacionBeca;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'DescargaLayoutDictaminacionBeca');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::DescargaLayoutDictaminacionBeca',  '_route' => 'DescargaLayoutDictaminacionBeca',);
                }
                not_DescargaLayoutDictaminacionBeca:

                // importarlayaoutdictaminacionbeca
                if ($pathinfo === '/api/Becas/SolicitudBeca/Dictaminacion/importarlayaoutdictaminacionbeca') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_importarlayaoutdictaminacionbeca;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::importarlayaoutdictaminacionbeca',  '_route' => 'importarlayaoutdictaminacionbeca',);
                }
                not_importarlayaoutdictaminacionbeca:

            }

            // CancelaSolicitudBeca
            if ($pathinfo === '/api/ConsultaBecas/CancelaSolicitud') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_CancelaSolicitudBeca;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Becas\\SolicitudBecaController::CancelaSolicitudBeca',  '_route' => 'CancelaSolicitudBeca',);
            }
            not_CancelaSolicitudBeca:

            if (0 === strpos($pathinfo, '/api/Becas')) {
                if (0 === strpos($pathinfo, '/api/Becas/Tipo')) {
                    // tipobecasfiltro
                    if ($pathinfo === '/api/Becas/TiposBecas/Filtrar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_tipobecasfiltro;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TipoBecasController::tipobecasfiltro',  '_route' => 'tipobecasfiltro',);
                    }
                    not_tipobecasfiltro:

                    if (0 === strpos($pathinfo, '/api/Becas/TipoBeca')) {
                        // BuscarTiposBecasNiveles
                        if (preg_match('#^/api/Becas/TipoBeca/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarTiposBecasNiveles;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarTiposBecasNiveles')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\TipoBecasController::BuscarTiposBecasNiveles',));
                        }
                        not_BuscarTiposBecasNiveles:

                        // GuardarTipoBecasNiveles
                        if ($pathinfo === '/api/Becas/TipoBeca') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarTipoBecasNiveles;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TipoBecasController::GuardarTipoBecasNiveles',  '_route' => 'GuardarTipoBecasNiveles',);
                        }
                        not_GuardarTipoBecasNiveles:

                    }

                }

                // EliminarTipoBecasNiveles
                if (0 === strpos($pathinfo, '/api/Becas/Niveles') && preg_match('#^/api/Becas/Niveles/(?P<porcentajebecaid>[^/]++)/(?P<nivelid>[^/]++)/(?P<tipobecaid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarTipoBecasNiveles;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarTipoBecasNiveles')), array (  '_controller' => 'AppBundle\\Controller\\Becas\\TipoBecasController::EliminarTipoBecasNiveles',));
                }
                not_EliminarTipoBecasNiveles:

                if (0 === strpos($pathinfo, '/api/Becas/TrabajadoraSocial')) {
                    // getTrabajadoraSocial
                    if ($pathinfo === '/api/Becas/TrabajadoraSocial/Filtrar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getTrabajadoraSocial;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TrabajadoraSocialController::IndexTrabajadoraSocial',  '_route' => 'getTrabajadoraSocial',);
                    }
                    not_getTrabajadoraSocial:

                    // ConsultaSolicitudBecasTrabajadoraSocialfiltro
                    if ($pathinfo === '/api/Becas/TrabajadoraSocial/Consultar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ConsultaSolicitudBecasTrabajadoraSocialfiltro;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TrabajadoraSocialController::ConsultaSolicitudBecasTrabajadoraSocialfiltro',  '_route' => 'ConsultaSolicitudBecasTrabajadoraSocialfiltro',);
                    }
                    not_ConsultaSolicitudBecasTrabajadoraSocialfiltro:

                    // GuardarUsuarioTrabajadorSocial
                    if ($pathinfo === '/api/Becas/TrabajadoraSocial/Usuario') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarUsuarioTrabajadorSocial;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TrabajadoraSocialController::GuardarUsuarioTrabajadorSocial',  '_route' => 'GuardarUsuarioTrabajadorSocial',);
                    }
                    not_GuardarUsuarioTrabajadorSocial:

                    // RetirarUsuarioTrabajadorSocial
                    if ($pathinfo === '/api/Becas/TrabajadoraSocial/RetirarUsuario') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_RetirarUsuarioTrabajadorSocial;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Becas\\TrabajadoraSocialController::RetirarUsuarioTrabajadorSocial',  '_route' => 'RetirarUsuarioTrabajadorSocial',);
                    }
                    not_RetirarUsuarioTrabajadorSocial:

                }

            }

            if (0 === strpos($pathinfo, '/api/Co')) {
                if (0 === strpos($pathinfo, '/api/Cobranza')) {
                    if (0 === strpos($pathinfo, '/api/Cobranza/A')) {
                        if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo')) {
                            // indexAcuerdo
                            if ($pathinfo === '/api/Cobranza/Acuerdo') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAcuerdo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::indexAcuerdo',  '_route' => 'indexAcuerdo',);
                            }
                            not_indexAcuerdo:

                            // BuscarAcuerdo
                            if (rtrim($pathinfo, '/') === '/api/Cobranza/Acuerdo') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarAcuerdo;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarAcuerdo');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdo',  '_route' => 'BuscarAcuerdo',);
                            }
                            not_BuscarAcuerdo:

                            // CancelarAcuerdo
                            if ($pathinfo === '/api/Cobranza/Acuerdo/Cancelar') {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_CancelarAcuerdo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::cancelAcuerdo',  '_route' => 'CancelarAcuerdo',);
                            }
                            not_CancelarAcuerdo:

                            // getAcuerdoPrecarga
                            if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Precarga') && preg_match('#^/api/Cobranza/Acuerdo/Precarga/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getAcuerdoPrecarga;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getAcuerdoPrecarga')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdoPrecarga',));
                            }
                            not_getAcuerdoPrecarga:

                            if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modal')) {
                                // AcuerdoModalGeneral
                                if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modalgeneral') && preg_match('#^/api/Cobranza/Acuerdo/Modalgeneral/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_AcuerdoModalGeneral;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'AcuerdoModalGeneral')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdoModalGeneral',));
                                }
                                not_AcuerdoModalGeneral:

                                // AcuerdoModalAcuerdo
                                if (rtrim($pathinfo, '/') === '/api/Cobranza/Acuerdo/Modalacuerdo') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_AcuerdoModalAcuerdo;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'AcuerdoModalAcuerdo');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdoModalAcuerdo',  '_route' => 'AcuerdoModalAcuerdo',);
                                }
                                not_AcuerdoModalAcuerdo:

                            }

                            // GuardarAcuerdo
                            if ($pathinfo === '/api/Cobranza/Acuerdo') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardarAcuerdo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::SaveAcuerdo',  '_route' => 'GuardarAcuerdo',);
                            }
                            not_GuardarAcuerdo:

                            // ActualizarAcuerdo
                            if (preg_match('#^/api/Cobranza/Acuerdo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_ActualizarAcuerdo;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarAcuerdo')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::updateAcuerdo',));
                            }
                            not_ActualizarAcuerdo:

                            if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modal')) {
                                if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modaldocumentos')) {
                                    // AcuerdoModalDocumento
                                    if (preg_match('#^/api/Cobranza/Acuerdo/Modaldocumentos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_AcuerdoModalDocumento;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AcuerdoModalDocumento')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdoModalDocumento',));
                                    }
                                    not_AcuerdoModalDocumento:

                                    // GuardarAcuerdoModalDocumento
                                    if (preg_match('#^/api/Cobranza/Acuerdo/Modaldocumentos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_GuardarAcuerdoModalDocumento;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarAcuerdoModalDocumento')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::saveAcuerdoModalDocumento',));
                                    }
                                    not_GuardarAcuerdoModalDocumento:

                                    // DescargarAcuerdoModalDocumento
                                    if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modaldocumentos/Descargar') && preg_match('#^/api/Cobranza/Acuerdo/Modaldocumentos/Descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_DescargarAcuerdoModalDocumento;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarAcuerdoModalDocumento')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::downloadAcuerdoModalDocumento',));
                                    }
                                    not_DescargarAcuerdoModalDocumento:

                                }

                                if (0 === strpos($pathinfo, '/api/Cobranza/Acuerdo/Modalbitacora')) {
                                    // AcuerdoModalBitacora
                                    if (preg_match('#^/api/Cobranza/Acuerdo/Modalbitacora/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_AcuerdoModalBitacora;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AcuerdoModalBitacora')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::getAcuerdoModalBitacora',));
                                    }
                                    not_AcuerdoModalBitacora:

                                    // GuardarAcuerdoModalBitacora
                                    if (preg_match('#^/api/Cobranza/Acuerdo/Modalbitacora/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_GuardarAcuerdoModalBitacora;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarAcuerdoModalBitacora')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AcuerdoController::saveAcuerdoModalBitacora',));
                                    }
                                    not_GuardarAcuerdoModalBitacora:

                                }

                            }

                        }

                        if (0 === strpos($pathinfo, '/api/Cobranza/Adeudosvencido')) {
                            // indexAdeudo
                            if ($pathinfo === '/api/Cobranza/Adeudosvencido/filtros') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAdeudo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AdeudovencidoController::indexAdeudo',  '_route' => 'indexAdeudo',);
                            }
                            not_indexAdeudo:

                            // BuscarAdeudoVencido
                            if (rtrim($pathinfo, '/') === '/api/Cobranza/Adeudosvencido') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarAdeudoVencido;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarAdeudoVencido');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AdeudovencidoController::BuscarAdeudoVencido',  '_route' => 'BuscarAdeudoVencido',);
                            }
                            not_BuscarAdeudoVencido:

                            // BuscarAdeudosVencidosDetalle
                            if ($pathinfo === '/api/Cobranza/Adeudosvencido/reporte/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_BuscarAdeudosVencidosDetalle;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AdeudovencidoController::BuscarAdeudosVencidosDetalle',  '_route' => 'BuscarAdeudosVencidosDetalle',);
                            }
                            not_BuscarAdeudosVencidosDetalle:

                        }

                        if (0 === strpos($pathinfo, '/api/Cobranza/Agendacita')) {
                            // indexAgendacita
                            if ($pathinfo === '/api/Cobranza/Agendacita') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAgendacita;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::indexAction',  '_route' => 'indexAgendacita',);
                            }
                            not_indexAgendacita:

                            // BuscarAgendacita
                            if (rtrim($pathinfo, '/') === '/api/Cobranza/Agendacita') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarAgendacita;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarAgendacita');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::getAgendacita',  '_route' => 'BuscarAgendacita',);
                            }
                            not_BuscarAgendacita:

                            // BuscarPadresAgendaCita
                            if ($pathinfo === '/api/Cobranza/Agendacita/Tutores') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarPadresAgendaCita;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::getAgendacitaPadres',  '_route' => 'BuscarPadresAgendaCita',);
                            }
                            not_BuscarPadresAgendaCita:

                            // saveAgendacita
                            if ($pathinfo === '/api/Cobranza/Agendacita') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_saveAgendacita;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::saveAgendacita',  '_route' => 'saveAgendacita',);
                            }
                            not_saveAgendacita:

                            // updateAgendacita
                            if (preg_match('#^/api/Cobranza/Agendacita/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateAgendacita;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateAgendacita')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::updateAgendacita',));
                            }
                            not_updateAgendacita:

                            // AgendacitaDelete
                            if (preg_match('#^/api/Cobranza/Agendacita/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_AgendacitaDelete;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'AgendacitaDelete')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AgendaCitasController::deleteAgendacita',));
                            }
                            not_AgendacitaDelete:

                        }

                        if (0 === strpos($pathinfo, '/api/Cobranza/AlumnoAcuerdo')) {
                            // indexAlumnoAcuerdo
                            if ($pathinfo === '/api/Cobranza/AlumnoAcuerdo') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAlumnoAcuerdo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AlumnoAcuerdoController::indexAlumnoAcuerdo',  '_route' => 'indexAlumnoAcuerdo',);
                            }
                            not_indexAlumnoAcuerdo:

                            // BuscarAcuerdosAlumno
                            if ($pathinfo === '/api/Cobranza/AlumnoAcuerdo/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_BuscarAcuerdosAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\AlumnoAcuerdoController::BuscarAcuerdosAlumno',  '_route' => 'BuscarAcuerdosAlumno',);
                            }
                            not_BuscarAcuerdosAlumno:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Cobranza/Bloqueomanual')) {
                        // indexBloquemanual
                        if ($pathinfo === '/api/Cobranza/Bloqueomanual') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexBloquemanual;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::indexBloqueomanual',  '_route' => 'indexBloquemanual',);
                        }
                        not_indexBloquemanual:

                        // BuscarBloquemanual
                        if (rtrim($pathinfo, '/') === '/api/Cobranza/Bloqueomanual') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarBloquemanual;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarBloquemanual');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::getBloqueomanual',  '_route' => 'BuscarBloquemanual',);
                        }
                        not_BuscarBloquemanual:

                        // getBloqueomanualByAlumno
                        if (rtrim($pathinfo, '/') === '/api/Cobranza/Bloqueomanual/Alumno') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getBloqueomanualByAlumno;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'getBloqueomanualByAlumno');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::getBloqueomanualByAlumno',  '_route' => 'getBloqueomanualByAlumno',);
                        }
                        not_getBloqueomanualByAlumno:

                        // CancelarBloquemanual
                        if ($pathinfo === '/api/Cobranza/Bloqueomanual/Cancelar') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_CancelarBloquemanual;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::cancelBloquemanual',  '_route' => 'CancelarBloquemanual',);
                        }
                        not_CancelarBloquemanual:

                        // GuardarBloquemanual
                        if ($pathinfo === '/api/Cobranza/Bloqueomanual') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarBloquemanual;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::SaveBloquemanual',  '_route' => 'GuardarBloquemanual',);
                        }
                        not_GuardarBloquemanual:

                        // ActualizarBloquemanual
                        if (preg_match('#^/api/Cobranza/Bloqueomanual/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarBloquemanual;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarBloquemanual')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\BloqueoManualController::updateBloquemanual',));
                        }
                        not_ActualizarBloquemanual:

                    }

                    if (0 === strpos($pathinfo, '/api/Cobranza/Pago')) {
                        if (0 === strpos($pathinfo, '/api/Cobranza/Pagoinscripcion')) {
                            // indexPagoinscripcion
                            if ($pathinfo === '/api/Cobranza/Pagoinscripcion') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexPagoinscripcion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagoInscripcionController::indexPagoinscripcion',  '_route' => 'indexPagoinscripcion',);
                            }
                            not_indexPagoinscripcion:

                            // BuscarPagoinscripcion
                            if ($pathinfo === '/api/Cobranza/Pagoinscripcion/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_BuscarPagoinscripcion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagoInscripcionController::getPagoinscripcion',  '_route' => 'BuscarPagoinscripcion',);
                            }
                            not_BuscarPagoinscripcion:

                            // BuscarPagoinscripciondetalle
                            if ($pathinfo === '/api/Cobranza/Pagoinscripciondetalle/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_BuscarPagoinscripciondetalle;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagoInscripcionController::getPagoinscripciondetalle',  '_route' => 'BuscarPagoinscripciondetalle',);
                            }
                            not_BuscarPagoinscripciondetalle:

                        }

                        if (0 === strpos($pathinfo, '/api/Cobranza/Pagos')) {
                            if (0 === strpos($pathinfo, '/api/Cobranza/PagosAdmision')) {
                                // indexPagosAdmision
                                if ($pathinfo === '/api/Cobranza/PagosAdmision') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_indexPagosAdmision;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosAdmisionController::indexPagosAdmision',  '_route' => 'indexPagosAdmision',);
                                }
                                not_indexPagosAdmision:

                                // BuscarPagosAdmision
                                if ($pathinfo === '/api/Cobranza/PagosAdmision/Filtrar') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_BuscarPagosAdmision;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosAdmisionController::BuscarPagosAdmision',  '_route' => 'BuscarPagosAdmision',);
                                }
                                not_BuscarPagosAdmision:

                            }

                            if (0 === strpos($pathinfo, '/api/Cobranza/PagosDiversos')) {
                                // DatosIniciales
                                if ($pathinfo === '/api/Cobranza/PagosDiversos/DatosIniciales') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_DatosIniciales;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosDiversosController::DatosIniciales',  '_route' => 'DatosIniciales',);
                                }
                                not_DatosIniciales:

                                // Filtrar
                                if ($pathinfo === '/api/Cobranza/PagosDiversos/Filtrar') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_Filtrar;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosDiversosController::Filtrar',  '_route' => 'Filtrar',);
                                }
                                not_Filtrar:

                                // obtenerAlumnos
                                if ($pathinfo === '/api/Cobranza/PagosDiversos/Alumnos') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_obtenerAlumnos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosDiversosController::AlumnosPorGrupo',  '_route' => 'obtenerAlumnos',);
                                }
                                not_obtenerAlumnos:

                                // guardarDocumentos
                                if ($pathinfo === '/api/Cobranza/PagosDiversos/Guardar') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_guardarDocumentos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosDiversosController::GuardarDocumentosPorPagar',  '_route' => 'guardarDocumentos',);
                                }
                                not_guardarDocumentos:

                                // VerificarMatriculas
                                if ($pathinfo === '/api/Cobranza/PagosDiversos/VerificarMatriculas') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_VerificarMatriculas;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\PagosDiversosController::VerificarMatriculas',  '_route' => 'VerificarMatriculas',);
                                }
                                not_VerificarMatriculas:

                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Cobranza/Reportecobranza')) {
                        // indexReportecobranza
                        if ($pathinfo === '/api/Cobranza/Reportecobranza') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexReportecobranza;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\ReportecobranzaController::indexReportecobranza',  '_route' => 'indexReportecobranza',);
                        }
                        not_indexReportecobranza:

                        // BuscarReportecobranza
                        if (rtrim($pathinfo, '/') === '/api/Cobranza/Reportecobranza') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarReportecobranza;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarReportecobranza');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\ReportecobranzaController::getReportecobranza',  '_route' => 'BuscarReportecobranza',);
                        }
                        not_BuscarReportecobranza:

                        // FamiliaSaldosPendientes
                        if ($pathinfo === '/api/Cobranza/Reportecobranza/FamiliaSaldosPendientes') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_FamiliaSaldosPendientes;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\ReportecobranzaController::FamiliaSaldosPendientes',  '_route' => 'FamiliaSaldosPendientes',);
                        }
                        not_FamiliaSaldosPendientes:

                        // EmailReportecobranza
                        if ($pathinfo === '/api/Cobranza/Reportecobranza') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_EmailReportecobranza;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\ReportecobranzaController::emailReportecobranza',  '_route' => 'EmailReportecobranza',);
                        }
                        not_EmailReportecobranza:

                        // DownloadReportecobranza
                        if (rtrim($pathinfo, '/') === '/api/Cobranza/Reportecobranza/Imprimir') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_DownloadReportecobranza;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'DownloadReportecobranza');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\ReportecobranzaController::downloadReportecobranza',  '_route' => 'DownloadReportecobranza',);
                        }
                        not_DownloadReportecobranza:

                    }

                    if (0 === strpos($pathinfo, '/api/Cobranza/Seguimiento')) {
                        // BuscarSeguimiento
                        if (rtrim($pathinfo, '/') === '/api/Cobranza/Seguimiento') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarSeguimiento;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarSeguimiento');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\SeguimientoController::getSeguimiento',  '_route' => 'BuscarSeguimiento',);
                        }
                        not_BuscarSeguimiento:

                        // indexSeguimiento
                        if (0 === strpos($pathinfo, '/api/Cobranza/Seguimiento/Bitacora') && preg_match('#^/api/Cobranza/Seguimiento/Bitacora/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexSeguimiento;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'indexSeguimiento')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\SeguimientoController::indexSeguimiento',));
                        }
                        not_indexSeguimiento:

                        // GuardarSeguimiento
                        if (preg_match('#^/api/Cobranza/Seguimiento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarSeguimiento;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarSeguimiento')), array (  '_controller' => 'AppBundle\\Controller\\Cobranza\\SeguimientoController::SaveSeguimiento',));
                        }
                        not_GuardarSeguimiento:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Comunicacion/Notificacion')) {
                    // BuscarNotificacion
                    if ($pathinfo === '/api/Comunicacion/Notificacion/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarNotificacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::getNotificacion',  '_route' => 'BuscarNotificacion',);
                    }
                    not_BuscarNotificacion:

                    // EliminarNotificacion
                    if (preg_match('#^/api/Comunicacion/Notificacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarNotificacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarNotificacion')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::deleteNotificacion',));
                    }
                    not_EliminarNotificacion:

                    // indexNotificacionCaptura
                    if ($pathinfo === '/api/Comunicacion/Notificacion/Captura') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexNotificacionCaptura;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::indexNotificacionCaptura',  '_route' => 'indexNotificacionCaptura',);
                    }
                    not_indexNotificacionCaptura:

                    // DestinatariosNotificacion
                    if (0 === strpos($pathinfo, '/api/Comunicacion/Notificacion/Destinatarios') && preg_match('#^/api/Comunicacion/Notificacion/Destinatarios/(?P<notificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DestinatariosNotificacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DestinatariosNotificacion')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::DestinatariosNotificacion',));
                    }
                    not_DestinatariosNotificacion:

                    // GuardarNotificacion
                    if ($pathinfo === '/api/Comunicacion/Notificacion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarNotificacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::SaveNotificacion',  '_route' => 'GuardarNotificacion',);
                    }
                    not_GuardarNotificacion:

                    // ActualizarNotificacion
                    if (preg_match('#^/api/Comunicacion/Notificacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarNotificacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarNotificacion')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::updateNotificacion',));
                    }
                    not_ActualizarNotificacion:

                    // ClonarNotificacion
                    if (0 === strpos($pathinfo, '/api/Comunicacion/Notificacion/Copiar') && preg_match('#^/api/Comunicacion/Notificacion/Copiar/(?P<notificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ClonarNotificacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ClonarNotificacion')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::ClonarNotificacion',));
                    }
                    not_ClonarNotificacion:

                    // ActualizarNotificacionDestinatarios
                    if (0 === strpos($pathinfo, '/api/Comunicacion/Notificacion/Destinatarios') && preg_match('#^/api/Comunicacion/Notificacion/Destinatarios/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ActualizarNotificacionDestinatarios;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarNotificacionDestinatarios')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::destinatarios',));
                    }
                    not_ActualizarNotificacionDestinatarios:

                    // GeneradorImagenNotificacion
                    if (0 === strpos($pathinfo, '/api/Comunicacion/Notificacion/Imagen') && preg_match('#^/api/Comunicacion/Notificacion/Imagen/(?P<news_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_GeneradorImagenNotificacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'GeneradorImagenNotificacion')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::GeneradorImagenNotificacion',));
                    }
                    not_GeneradorImagenNotificacion:

                    // EnvioNotificacion
                    if ($pathinfo === '/api/Comunicacion/Notificacion/Envio') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_EnvioNotificacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::EnvioNotificacion',  '_route' => 'EnvioNotificacion',);
                    }
                    not_EnvioNotificacion:

                }

            }

            if (0 === strpos($pathinfo, '/api/portalalumno/notificaciones')) {
                // BuscarNotificacionesAPP
                if ($pathinfo === '/api/portalalumno/notificaciones') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarNotificacionesAPP;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::getNotificacionesAPP',  '_route' => 'BuscarNotificacionesAPP',);
                }
                not_BuscarNotificacionesAPP:

                // ActualizarNotificacionAPP
                if (preg_match('#^/api/portalalumno/notificaciones/(?P<notificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarNotificacionAPP;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarNotificacionAPP')), array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\NotificacionController::updateNotificacionAPP',));
                }
                not_ActualizarNotificacionAPP:

            }

            if (0 === strpos($pathinfo, '/api/Co')) {
                if (0 === strpos($pathinfo, '/api/Comunicacion/Tablero')) {
                    // indexTablero
                    if ($pathinfo === '/api/Comunicacion/Tablero') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexTablero;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\TableroController::indexTablero',  '_route' => 'indexTablero',);
                    }
                    not_indexTablero:

                    // BuscarTablero
                    if ($pathinfo === '/api/Comunicacion/Tablero') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarTablero;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\TableroController::getTablero',  '_route' => 'BuscarTablero',);
                    }
                    not_BuscarTablero:

                    // BuscarDetalle
                    if ($pathinfo === '/api/Comunicacion/Tablero/tiponotificacion/notificacion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarDetalle;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Comunicacion\\TableroController::getTableroDetalle',  '_route' => 'BuscarDetalle',);
                    }
                    not_BuscarDetalle:

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Agendaexamen')) {
                        // indexAgendaexamen
                        if ($pathinfo === '/api/Controlescolar/Agendaexamen') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexAgendaexamen;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::indexAgendaexamen',  '_route' => 'indexAgendaexamen',);
                        }
                        not_indexAgendaexamen:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Agendaexamen/Filtrar')) {
                            // filtrarprofesoragenda
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/Agendaexamen/FiltrarProfesor') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_filtrarprofesoragenda;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'filtrarprofesoragenda');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::filtrarprofesornivel',  '_route' => 'filtrarprofesoragenda',);
                            }
                            not_filtrarprofesoragenda:

                            // filtraragenda
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/Agendaexamen/Filtrar') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_filtraragenda;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'filtraragenda');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::filtraragenda',  '_route' => 'filtraragenda',);
                            }
                            not_filtraragenda:

                        }

                        // SaveAgendaexamen
                        if ($pathinfo === '/api/Controlescolar/Agendaexamen') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_SaveAgendaexamen;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::SaveAgendaexamen',  '_route' => 'SaveAgendaexamen',);
                        }
                        not_SaveAgendaexamen:

                    }

                    // CancelarAgendaexamen
                    if ($pathinfo === '/api/Controlescolar/CancelarAgendaexamen') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_CancelarAgendaexamen;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::CancelarAgendaexamen',  '_route' => 'CancelarAgendaexamen',);
                    }
                    not_CancelarAgendaexamen:

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Agendaexamen')) {
                        // ActualizarAgendaexamen
                        if (preg_match('#^/api/Controlescolar/Agendaexamen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarAgendaexamen;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarAgendaexamen')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::updateAgenda',));
                        }
                        not_ActualizarAgendaexamen:

                        // EliminarAgendaexamen
                        if (preg_match('#^/api/Controlescolar/Agendaexamen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarAgendaexamen;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarAgendaexamen')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AgendaExamenController::deleteAgendaexamen',));
                        }
                        not_EliminarAgendaexamen:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/Alumno')) {
                // ActividadAlumno
                if ($pathinfo === '/api/Alumno/Actividad') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ActividadAlumno;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::ActividadAlumno',  '_route' => 'ActividadAlumno',);
                }
                not_ActividadAlumno:

                // InicioAlumno
                if ($pathinfo === '/api/Alumno') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_InicioAlumno;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::indexAlumno',  '_route' => 'InicioAlumno',);
                }
                not_InicioAlumno:

                // BuscarAlumnoExpediente
                if (rtrim($pathinfo, '/') === '/api/Alumno') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAlumnoExpediente;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarAlumnoExpediente');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getAlumno',  '_route' => 'BuscarAlumnoExpediente',);
                }
                not_BuscarAlumnoExpediente:

                // getalumnoFoto
                if ($pathinfo === '/api/Alumno/foto') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getalumnoFoto;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getalumnoFoto',  '_route' => 'getalumnoFoto',);
                }
                not_getalumnoFoto:

                // BuscarAlumnoPadres
                if (rtrim($pathinfo, '/') === '/api/AlumnoPadre') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAlumnoPadres;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarAlumnoPadres');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getAlumnoPadre',  '_route' => 'BuscarAlumnoPadres',);
                }
                not_BuscarAlumnoPadres:

                // BuscarAlumnoReciboInscipcion
                if (0 === strpos($pathinfo, '/api/Alumno/Reciboinscripcion') && preg_match('#^/api/Alumno/Reciboinscripcion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAlumnoReciboInscipcion;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAlumnoReciboInscipcion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getAlumnoReciboInscripcion',));
                }
                not_BuscarAlumnoReciboInscipcion:

                // BuscarAlumnoEstadoCuenta
                if (0 === strpos($pathinfo, '/api/Alumno/Estadocuenta') && preg_match('#^/api/Alumno/Estadocuenta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAlumnoEstadoCuenta;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAlumnoEstadoCuenta')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getAlumnoEstadoCuenta',));
                }
                not_BuscarAlumnoEstadoCuenta:

            }

            // CEAAlumnoCatalogos
            if ($pathinfo === '/api/Controlescolar/Alumno') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_CEAAlumnoCatalogos;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::CEAAlumnoCatalogosDatos',  '_route' => 'CEAAlumnoCatalogos',);
            }
            not_CEAAlumnoCatalogos:

            if (0 === strpos($pathinfo, '/api/portalfamiliar')) {
                // PPEditarDatosAlumno
                if (preg_match('#^/api/portalfamiliar/(?P<sistema>[^/]++)/Alumno$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_PPEditarDatosAlumno;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPEditarDatosAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::EditarDatosAlumno',));
                }
                not_PPEditarDatosAlumno:

                // PPGetCatalogosDatosAlumnoLUX
                if (0 === strpos($pathinfo, '/api/portalfamiliar/LUX/CatalogosDatosAlumno') && preg_match('#^/api/portalfamiliar/LUX/CatalogosDatosAlumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_PPGetCatalogosDatosAlumnoLUX;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetCatalogosDatosAlumnoLUX')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GetCatalogosDatosAlumno',));
                }
                not_PPGetCatalogosDatosAlumnoLUX:

                // PPGetCatalogosDatosAlumnoCiencias
                if (0 === strpos($pathinfo, '/api/portalfamiliar/Ciencias/CatalogosDatosAlumno') && preg_match('#^/api/portalfamiliar/Ciencias/CatalogosDatosAlumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_PPGetCatalogosDatosAlumnoCiencias;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetCatalogosDatosAlumnoCiencias')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GetCatalogosDatosAlumnoCiencias',));
                }
                not_PPGetCatalogosDatosAlumnoCiencias:

                // PPGetPersonasAutorizadasRecogerAlumno
                if (0 === strpos($pathinfo, '/api/portalfamiliar/PersonasAutorizadasRecogerAlumno') && preg_match('#^/api/portalfamiliar/PersonasAutorizadasRecogerAlumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_PPGetPersonasAutorizadasRecogerAlumno;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetPersonasAutorizadasRecogerAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GetPersonasAutorizadasRecogerAlumno',));
                }
                not_PPGetPersonasAutorizadasRecogerAlumno:

                // PPGetHermanoAlumno
                if (0 === strpos($pathinfo, '/api/portalfamiliar/Hermano') && preg_match('#^/api/portalfamiliar/Hermano/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_PPGetHermanoAlumno;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetHermanoAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GetHermanoAlumno',));
                }
                not_PPGetHermanoAlumno:

                // PPGetPadresOTutoresAlumno
                if (0 === strpos($pathinfo, '/api/portalfamiliar/PadresOTutoresAlumno') && preg_match('#^/api/portalfamiliar/PadresOTutoresAlumno/(?P<clave>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_PPGetPadresOTutoresAlumno;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetPadresOTutoresAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GetPadresOTutoresAlumno',));
                }
                not_PPGetPadresOTutoresAlumno:

            }

            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno')) {
                // CEAAlumnoFotos
                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Fotos') && preg_match('#^/api/Controlescolar/Alumno/Fotos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_CEAAlumnoFotos;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'CEAAlumnoFotos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::CEAAlumnoFotos',));
                }
                not_CEAAlumnoFotos:

                // GuardarCustodia
                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Custodia') && preg_match('#^/api/Controlescolar/Alumno/Custodia/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarCustodia;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarCustodia')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::GuardarCustodia',));
                }
                not_GuardarCustodia:

                // CEAAlumno
                if (rtrim($pathinfo, '/') === '/api/Controlescolar/Alumno') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_CEAAlumno;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'CEAAlumno');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::CEAlumno',  '_route' => 'CEAAlumno',);
                }
                not_CEAAlumno:

            }

            if (0 === strpos($pathinfo, '/api/Alumno')) {
                // getAlumnoExamenBancoReactivos
                if (0 === strpos($pathinfo, '/api/Alumno/Examenes') && preg_match('#^/api/Alumno/Examenes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getAlumnoExamenBancoReactivos;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getAlumnoExamenBancoReactivos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getAlumnoExamenBancoReactivos',));
                }
                not_getAlumnoExamenBancoReactivos:

                // getPeriodosevaluacionbyalumno
                if (rtrim($pathinfo, '/') === '/api/Alumno/Periodosevaluacion') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getPeriodosevaluacionbyalumno;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'getPeriodosevaluacionbyalumno');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoController::getPeriodosevaluacionbyalumno',  '_route' => 'getPeriodosevaluacionbyalumno',);
                }
                not_getPeriodosevaluacionbyalumno:

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/A')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumnoidiomanivel')) {
                                // getAINFilter
                                if ($pathinfo === '/api/Controlescolar/Alumnoidiomanivel/filter') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getAINFilter;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelController::getAINFilter',  '_route' => 'getAINFilter',);
                                }
                                not_getAINFilter:

                                // getAINAlumnos
                                if ($pathinfo === '/api/Controlescolar/Alumnoidiomanivel') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getAINAlumnos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelController::getAINAlumnos',  '_route' => 'getAINAlumnos',);
                                }
                                not_getAINAlumnos:

                                // setAINAlumnoIdiomaNivel
                                if (preg_match('#^/api/Controlescolar/Alumnoidiomanivel/(?P<idiomanivelid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_setAINAlumnoIdiomaNivel;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'setAINAlumnoIdiomaNivel')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelController::setAINAlumnoIdiomaNivel',));
                                }
                                not_setAINAlumnoIdiomaNivel:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumnoidiomanivelimportar')) {
                                    // getAINIFilter
                                    if ($pathinfo === '/api/Controlescolar/Alumnoidiomanivelimportar/filter') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getAINIFilter;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelImportarController::getAINIFilter',  '_route' => 'getAINIFilter',);
                                    }
                                    not_getAINIFilter:

                                    // getAINIFile
                                    if (rtrim($pathinfo, '/') === '/api/Controlescolar/Alumnoidiomanivelimportar') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getAINIFile;
                                        }

                                        if (substr($pathinfo, -1) !== '/') {
                                            return $this->redirect($pathinfo.'/', 'getAINIFile');
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelImportarController::getAINIFile',  '_route' => 'getAINIFile',);
                                    }
                                    not_getAINIFile:

                                    // setAINIFileByExcel
                                    if (preg_match('#^/api/Controlescolar/Alumnoidiomanivelimportar/(?P<cicloid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_setAINIFileByExcel;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'setAINIFileByExcel')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoIdiomaNivelImportarController::setAINIFileByExcel',));
                                    }
                                    not_setAINIFileByExcel:

                                }

                            }

                            // AlumnoSolicitudFilters
                            if ($pathinfo === '/api/Controlescolar/Alumno/Solicitud') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_AlumnoSolicitudFilters;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\AdmisionesController::solicitudFilterAction',  '_route' => 'AlumnoSolicitudFilters',);
                            }
                            not_AlumnoSolicitudFilters:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/DatosMedicos')) {
                                // BuscarDatosMedicos
                                if (preg_match('#^/api/Controlescolar/Alumno/DatosMedicos/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_BuscarDatosMedicos;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarDatosMedicos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\AreaMedicaController::BuscarDatosMedicos',));
                                }
                                not_BuscarDatosMedicos:

                                // GuardaDatosMedicos
                                if (preg_match('#^/api/Controlescolar/Alumno/DatosMedicos/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardaDatosMedicos;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardaDatosMedicos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\AreaMedicaController::GuardaDatosMedicos',));
                                }
                                not_GuardaDatosMedicos:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/C')) {
                                // alumnobecasfiltro
                                if ($pathinfo === '/api/Controlescolar/Alumno/ConsultaBecas/Filtrar') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_alumnobecasfiltro;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\BecasController::becasfiltro',  '_route' => 'alumnobecasfiltro',);
                                }
                                not_alumnobecasfiltro:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Certificacion')) {
                                    // getCertificaciones
                                    if (preg_match('#^/api/Controlescolar/Alumno/Certificacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getCertificaciones;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCertificaciones')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\CertificacionesController::getCertificaciones',));
                                    }
                                    not_getCertificaciones:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Certificacion/eliminar')) {
                                        // EliminarCert
                                        if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Certificacion/eliminarcert') && preg_match('#^/api/Controlescolar/Alumno/Certificacion/eliminarcert/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'DELETE') {
                                                $allow[] = 'DELETE';
                                                goto not_EliminarCert;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCert')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\CertificacionesController::EliminarCert',));
                                        }
                                        not_EliminarCert:

                                        // deleteCertificaciones
                                        if (preg_match('#^/api/Controlescolar/Alumno/Certificacion/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'DELETE') {
                                                $allow[] = 'DELETE';
                                                goto not_deleteCertificaciones;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteCertificaciones')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\CertificacionesController::deleteCertificaciones',));
                                        }
                                        not_deleteCertificaciones:

                                    }

                                    // SaveCertificacion
                                    if ($pathinfo === '/api/Controlescolar/Alumno/Certificacion') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_SaveCertificacion;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\CertificacionesController::SaveCertificacion',  '_route' => 'SaveCertificacion',);
                                    }
                                    not_SaveCertificacion:

                                    // updateCertficacion
                                    if (preg_match('#^/api/Controlescolar/Alumno/Certificacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'PUT') {
                                            $allow[] = 'PUT';
                                            goto not_updateCertficacion;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateCertficacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\CertificacionesController::updateCertficacion',));
                                    }
                                    not_updateCertficacion:

                                }

                                // indexContactoEmergencia
                                if ($pathinfo === '/api/Controlescolar/Alumno/ContactoEmergencia') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_indexContactoEmergencia;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\ContactoEmergenciaController::indexContactoEmergencia',  '_route' => 'indexContactoEmergencia',);
                                }
                                not_indexContactoEmergencia:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/DatosGenerales')) {
                                // CEAAlumnoDatosGenerales
                                if (preg_match('#^/api/Controlescolar/Alumno/DatosGenerales/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_CEAAlumnoDatosGenerales;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'CEAAlumnoDatosGenerales')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\DatosGeneralesController::CEAAlumnoDatosGenerales',));
                                }
                                not_CEAAlumnoDatosGenerales:

                                // GuardarAlumno
                                if ($pathinfo === '/api/Controlescolar/Alumno/DatosGenerales') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\DatosGeneralesController::GuardarAlumno',  '_route' => 'GuardarAlumno',);
                                }
                                not_GuardarAlumno:

                            }

                            // CEAAlumnoFamilia
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/Alumno/Familia') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_CEAAlumnoFamilia;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'CEAAlumnoFamilia');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\FamiliarController::GetAlumnoFamilia',  '_route' => 'CEAAlumnoFamilia',);
                            }
                            not_CEAAlumnoFamilia:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Padre')) {
                                // CEGetPadresOTutoresDatos
                                if ($pathinfo === '/api/Controlescolar/Alumno/PadreOTutor') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_CEGetPadresOTutoresDatos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\FamiliarController::CEGetPadresOTutoresDatos',  '_route' => 'CEGetPadresOTutoresDatos',);
                                }
                                not_CEGetPadresOTutoresDatos:

                                // CEAAlumnoCatalogosPadresOTutores
                                if ($pathinfo === '/api/Controlescolar/Alumno/PadresOTutores') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_CEAAlumnoCatalogosPadresOTutores;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\FamiliarController::CEAAlumnoCatalogosPadresOTutores',  '_route' => 'CEAAlumnoCatalogosPadresOTutores',);
                                }
                                not_CEAAlumnoCatalogosPadresOTutores:

                            }

                            // guardardomicilioalumno
                            if ($pathinfo === '/api/Controlescolar/Alumno/Familia/GuardarDomicilio') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_guardardomicilioalumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\FamiliarController::GuardarDomicilioAlumno',  '_route' => 'guardardomicilioalumno',);
                            }
                            not_guardardomicilioalumno:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/H')) {
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Historial')) {
                                    // HistorialAcademico
                                    if ($pathinfo === '/api/Controlescolar/Alumno/HistorialAcademico') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_HistorialAcademico;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\HistorialFinancieroController::getHistorialAcademico',  '_route' => 'HistorialAcademico',);
                                    }
                                    not_HistorialAcademico:

                                    // getHistorialSubgrupos
                                    if ($pathinfo === '/api/Controlescolar/Alumno/HistorialSubgrupos') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getHistorialSubgrupos;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\HistorialFinancieroController::getHistorialSubgrupos',  '_route' => 'getHistorialSubgrupos',);
                                    }
                                    not_getHistorialSubgrupos:

                                    // HistorialFinanciero
                                    if ($pathinfo === '/api/Controlescolar/Alumno/HistorialFinanciero') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_HistorialFinanciero;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\HistorialFinancieroController::getHistorialFinanciero',  '_route' => 'HistorialFinanciero',);
                                    }
                                    not_HistorialFinanciero:

                                }

                                // HorarioAlumno
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Horario') && preg_match('#^/api/Controlescolar/Alumno/Horario/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_HorarioAlumno;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'HorarioAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\HorarioController::getHorario',));
                                }
                                not_HorarioAlumno:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Alumno/Subgrupos')) {
                                // getDatoalumnobyciclo
                                if ($pathinfo === '/api/Controlescolar/Alumno/Subgrupos/Datoalumno') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getDatoalumnobyciclo;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\SubgruposController::getDatoalumnobyciclo',  '_route' => 'getDatoalumnobyciclo',);
                                }
                                not_getDatoalumnobyciclo:

                                // GetSubgrupoTallerAlumno
                                if ($pathinfo === '/api/Controlescolar/Alumno/Subgrupos/Grupotalleralumno') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_GetSubgrupoTallerAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnoModal\\SubgruposController::GetSubgrupoTallerAlumno',  '_route' => 'GetSubgrupoTallerAlumno',);
                                }
                                not_GetSubgrupoTallerAlumno:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/AlumnosPerseverancia')) {
                                // indexAlumnosperseverancia
                                if ($pathinfo === '/api/Controlescolar/AlumnosPerseverancia') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_indexAlumnosperseverancia;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnosPerseveranciaController::indexAlumnosperseverancia',  '_route' => 'indexAlumnosperseverancia',);
                                }
                                not_indexAlumnosperseverancia:

                                // getAlumnosperseverancia
                                if (rtrim($pathinfo, '/') === '/api/Controlescolar/AlumnosPerseverancia') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getAlumnosperseverancia;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'getAlumnosperseverancia');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnosPerseveranciaController::getAlumnosperseverancia',  '_route' => 'getAlumnosperseverancia',);
                                }
                                not_getAlumnosperseverancia:

                                // setAlumnoPerseverancia
                                if ($pathinfo === '/api/Controlescolar/AlumnosPerseverancia/MarcarAlumnos') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_setAlumnoPerseverancia;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnosPerseveranciaController::setAlumnoPerseverancia',  '_route' => 'setAlumnoPerseverancia',);
                                }
                                not_setAlumnoPerseverancia:

                                // getAlumnoPerseveranciaFotos
                                if (0 === strpos($pathinfo, '/api/Controlescolar/AlumnosPerseverancia/DescargarFotos') && preg_match('#^/api/Controlescolar/AlumnosPerseverancia/DescargarFotos/(?P<alumnosciclo>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getAlumnoPerseveranciaFotos;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getAlumnoPerseveranciaFotos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AlumnosPerseveranciaController::getAlumnoPerseveranciaFotos',));
                                }
                                not_getAlumnoPerseveranciaFotos:

                            }

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/AprendizajesEsperados')) {
                            // indexAprendizajes
                            if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAprendizajes;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::indexAprendizajes',  '_route' => 'indexAprendizajes',);
                            }
                            not_indexAprendizajes:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/AprendizajesEsperados/G')) {
                                // getAprendizajesEsperados
                                if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/GetAprendizajesEsperados') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getAprendizajesEsperados;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::getAprendizajesEsperados',  '_route' => 'getAprendizajesEsperados',);
                                }
                                not_getAprendizajesEsperados:

                                // GuardarSubmateriasAprendizaje
                                if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/GuardarSubmateriasAprendizaje') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarSubmateriasAprendizaje;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::GuardarSubmateriasAprendizaje',  '_route' => 'GuardarSubmateriasAprendizaje',);
                                }
                                not_GuardarSubmateriasAprendizaje:

                            }

                            // EliminarSubmateriaAprendizaje
                            if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/EliminarSubmateriaAprendizaje/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_EliminarSubmateriaAprendizaje;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::EliminarSubmateriaAprendizaje',  '_route' => 'EliminarSubmateriaAprendizaje',);
                            }
                            not_EliminarSubmateriaAprendizaje:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/AprendizajesEsperados/Guardar')) {
                                // GuardarComentarioAprendizaje
                                if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/GuardarComentarioAprendizaje/') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarComentarioAprendizaje;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::GuardarComentarioAprendizaje',  '_route' => 'GuardarComentarioAprendizaje',);
                                }
                                not_GuardarComentarioAprendizaje:

                                // GuardarAprendizajeComentario
                                if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/GuardarAprendizajeComentario/') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarAprendizajeComentario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::GuardarAprendizajeComentario',  '_route' => 'GuardarAprendizajeComentario',);
                                }
                                not_GuardarAprendizajeComentario:

                            }

                            // CopiarAprendizajeInfo
                            if ($pathinfo === '/api/Controlescolar/AprendizajesEsperados/CopiarAprendizajeInfo/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_CopiarAprendizajeInfo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AprendizajesEsperadosController::CopiarAprendizajeInfo',  '_route' => 'CopiarAprendizajeInfo',);
                            }
                            not_CopiarAprendizajeInfo:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Ar')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Areaacademica')) {
                                // indexArea
                                if ($pathinfo === '/api/Controlescolar/Areaacademica') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_indexArea;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AreaAcademicaController::indexArea',  '_route' => 'indexArea',);
                                }
                                not_indexArea:

                                // BuscarArea
                                if (rtrim($pathinfo, '/') === '/api/Controlescolar/Areaacademica') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_BuscarArea;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'BuscarArea');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AreaAcademicaController::getArea',  '_route' => 'BuscarArea',);
                                }
                                not_BuscarArea:

                                // EliminarArea
                                if (preg_match('#^/api/Controlescolar/Areaacademica/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'DELETE') {
                                        $allow[] = 'DELETE';
                                        goto not_EliminarArea;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarArea')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AreaAcademicaController::deleteArea',));
                                }
                                not_EliminarArea:

                                // GuardarArea
                                if ($pathinfo === '/api/Controlescolar/Areaacademica') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarArea;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AreaAcademicaController::SaveArea',  '_route' => 'GuardarArea',);
                                }
                                not_GuardarArea:

                                // ActualizarArea
                                if (preg_match('#^/api/Controlescolar/Areaacademica/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_ActualizarArea;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarArea')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AreaAcademicaController::updateArea',));
                                }
                                not_ActualizarArea:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Armado')) {
                                // ArmadoGruposGet
                                if ($pathinfo === '/api/Controlescolar/Armadogrupos') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_ArmadoGruposGet;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoGruposGet',  '_route' => 'ArmadoGruposGet',);
                                }
                                not_ArmadoGruposGet:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Armadosubgrupos')) {
                                    // ArmadoSubGruposGet
                                    if ($pathinfo === '/api/Controlescolar/Armadosubgrupos') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_ArmadoSubGruposGet;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoSubGruposGet',  '_route' => 'ArmadoSubGruposGet',);
                                    }
                                    not_ArmadoSubGruposGet:

                                    // Armadosubgruposmaterias
                                    if ($pathinfo === '/api/Controlescolar/Armadosubgrupos/Materias') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_Armadosubgruposmaterias;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::Armadosubgruposmaterias',  '_route' => 'Armadosubgruposmaterias',);
                                    }
                                    not_Armadosubgruposmaterias:

                                }

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Armadogrupos/C')) {
                                    // CambiarBloqueo
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Armadogrupos/CambiarBloqueo') && preg_match('#^/api/Controlescolar/Armadogrupos/CambiarBloqueo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_CambiarBloqueo;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'CambiarBloqueo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::CambiarBloqueo',));
                                    }
                                    not_CambiarBloqueo:

                                    // ArmadoGruposConsulta
                                    if ($pathinfo === '/api/Controlescolar/Armadogrupos/Consulta') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_ArmadoGruposConsulta;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoGruposConsulta',  '_route' => 'ArmadoGruposConsulta',);
                                    }
                                    not_ArmadoGruposConsulta:

                                }

                                // ArmadoGruposSubConsulta
                                if ($pathinfo === '/api/Controlescolar/Armadosubgrupos/Consulta') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_ArmadoGruposSubConsulta;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoGruposSubConsulta',  '_route' => 'ArmadoGruposSubConsulta',);
                                }
                                not_ArmadoGruposSubConsulta:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Armadogrupos')) {
                                    // ArmadoGruposGuardar
                                    if ($pathinfo === '/api/Controlescolar/Armadogrupos/Guardar') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_ArmadoGruposGuardar;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoGruposGuardar',  '_route' => 'ArmadoGruposGuardar',);
                                    }
                                    not_ArmadoGruposGuardar:

                                    // ArmadoGruposCopiar
                                    if ($pathinfo === '/api/Controlescolar/Armadogrupos/Copiar') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_ArmadoGruposCopiar;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::ArmadoGruposCopiar',  '_route' => 'ArmadoGruposCopiar',);
                                    }
                                    not_ArmadoGruposCopiar:

                                    // getListaAlumnosGrupos
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Armadogrupos/listaAlumnosGrupo') && preg_match('#^/api/Controlescolar/Armadogrupos/listaAlumnosGrupo/(?P<grupoid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getListaAlumnosGrupos;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getListaAlumnosGrupos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoGruposSubgruposController::getListaAlumnosGrupos',));
                                    }
                                    not_getListaAlumnosGrupos:

                                }

                            }

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/preregistrocurricular')) {
                        // indexpreregistroTaller
                        if (preg_match('#^/api/Controlescolar/preregistrocurricular/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexpreregistroTaller;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'indexpreregistroTaller')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::indexpreregistroTaller',));
                        }
                        not_indexpreregistroTaller:

                        // SavePreregistroTallerCurricular
                        if ($pathinfo === '/api/Controlescolar/preregistrocurricular') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_SavePreregistroTallerCurricular;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::SavePreregistroTallerCurricular',  '_route' => 'SavePreregistroTallerCurricular',);
                        }
                        not_SavePreregistroTallerCurricular:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/Armado')) {
                            // setEliminarAlumno
                            if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/Armado/EliminarAlumno') && preg_match('#^/api/Controlescolar/TallerCurricular/Armado/EliminarAlumno/(?P<alumnocicloportallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_setEliminarAlumno;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'setEliminarAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::setEliminarAlumno',));
                            }
                            not_setEliminarAlumno:

                            // getFiltro
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/Filtro') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getFiltro;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getFiltro',  '_route' => 'getFiltro',);
                            }
                            not_getFiltro:

                            // getFiltroRotacion
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/Filtro') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getFiltroRotacion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getFiltroRotacion',  '_route' => 'getFiltroRotacion',);
                            }
                            not_getFiltroRotacion:

                            // getConsulta
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/Consulta') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getConsulta;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getConsulta',  '_route' => 'getConsulta',);
                            }
                            not_getConsulta:

                            // VerificarAlumnoMatricula
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/VerificarAlumnoMatricula') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_VerificarAlumnoMatricula;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::VerificarAlumnoMatricula',  '_route' => 'VerificarAlumnoMatricula',);
                            }
                            not_VerificarAlumnoMatricula:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/ArmadoRotacion')) {
                                // getConsultaRotacion
                                if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/Consultar') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getConsultaRotacion;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getConsultaRotacion',  '_route' => 'getConsultaRotacion',);
                                }
                                not_getConsultaRotacion:

                                // AsignacionAutomaticaRotacion
                                if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/AsignacionAutomatica') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_AsignacionAutomaticaRotacion;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::AsignacionAutomaticaRotacion',  '_route' => 'AsignacionAutomaticaRotacion',);
                                }
                                not_AsignacionAutomaticaRotacion:

                                // RotarTalleres
                                if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/RotarTalleres') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_RotarTalleres;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::RotarTalleres',  '_route' => 'RotarTalleres',);
                                }
                                not_RotarTalleres:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/ArmadoRotacion/E')) {
                                    // eliminarInscripcionRotacion
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/ArmadoRotacion/Eliminar') && preg_match('#^/api/Controlescolar/TallerCurricular/ArmadoRotacion/Eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'DELETE') {
                                            $allow[] = 'DELETE';
                                            goto not_eliminarInscripcionRotacion;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarInscripcionRotacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::eliminarInscripcionRotacion',));
                                    }
                                    not_eliminarInscripcionRotacion:

                                    // editarInscripcionRotacion
                                    if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/Editar') {
                                        if ($this->context->getMethod() != 'PUT') {
                                            $allow[] = 'PUT';
                                            goto not_editarInscripcionRotacion;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::editarInscripcionRotacion',  '_route' => 'editarInscripcionRotacion',);
                                    }
                                    not_editarInscripcionRotacion:

                                }

                                // AsignacionManualRotacion
                                if ($pathinfo === '/api/Controlescolar/TallerCurricular/ArmadoRotacion/AsignacionManual') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_AsignacionManualRotacion;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::AsignacionManualRotacion',  '_route' => 'AsignacionManualRotacion',);
                                }
                                not_AsignacionManualRotacion:

                            }

                            // AsignacionAutomatica
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/AsignacionAutomatica') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_AsignacionAutomatica;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::AsignacionAutomatica',  '_route' => 'AsignacionAutomatica',);
                            }
                            not_AsignacionAutomatica:

                            // CambiarAlumno
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/CambiarAlumno') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_CambiarAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::CambiarAlumno',  '_route' => 'CambiarAlumno',);
                            }
                            not_CambiarAlumno:

                            // AsignacionManual
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/AsignacionManual') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_AsignacionManual;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::AsignacionManual',  '_route' => 'AsignacionManual',);
                            }
                            not_AsignacionManual:

                        }

                        // getListaAlumnosTaller
                        if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/listaAlumnos') && preg_match('#^/api/Controlescolar/TallerCurricular/listaAlumnos/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getListaAlumnosTaller;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getListaAlumnosTaller')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getListaAlumnosTaller',));
                        }
                        not_getListaAlumnosTaller:

                        // getHorarioRotacion
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/TallerCurricular/HorarioRotacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getHorarioRotacion;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'getHorarioRotacion');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::getHorarioRotacion',  '_route' => 'getHorarioRotacion',);
                        }
                        not_getHorarioRotacion:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/TallerCurricular/Armado')) {
                            // seteoNumerolista
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/seteoNumerolista') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_seteoNumerolista;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::seteoNumerolista',  '_route' => 'seteoNumerolista',);
                            }
                            not_seteoNumerolista:

                            // RecalcularNoLista
                            if ($pathinfo === '/api/Controlescolar/TallerCurricular/Armado/RecalcularNoLista') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_RecalcularNoLista;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ArmadoTallerCurricularController::RecalcularNoLista',  '_route' => 'RecalcularNoLista',);
                            }
                            not_RecalcularNoLista:

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/api/ControlEscolar/Asistencia')) {
                    // BuscarAsistencias
                    if (rtrim($pathinfo, '/') === '/api/ControlEscolar/Asistencia') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarAsistencias;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarAsistencias');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::getAsistencias',  '_route' => 'BuscarAsistencias',);
                    }
                    not_BuscarAsistencias:

                    // ActualizarAsistencias
                    if ($pathinfo === '/api/ControlEscolar/Asistencia/Estatus') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarAsistencias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::updateAsistencias',  '_route' => 'ActualizarAsistencias',);
                    }
                    not_ActualizarAsistencias:

                }

            }

            if (0 === strpos($pathinfo, '/api/Asistencia')) {
                if (0 === strpos($pathinfo, '/api/Asistencia/Cancelacion')) {
                    // indexCancelacionInasistencias
                    if ($pathinfo === '/api/Asistencia/Cancelacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexCancelacionInasistencias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::indexCancelacionInasistencias',  '_route' => 'indexCancelacionInasistencias',);
                    }
                    not_indexCancelacionInasistencias:

                    // BuscarCancelacionInasistencias
                    if (rtrim($pathinfo, '/') === '/api/Asistencia/Cancelacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarCancelacionInasistencias;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarCancelacionInasistencias');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::getCancelacionInasistencias',  '_route' => 'BuscarCancelacionInasistencias',);
                    }
                    not_BuscarCancelacionInasistencias:

                    // ActualizarCancelacionInasistencias
                    if ($pathinfo === '/api/Asistencia/Cancelacion') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarCancelacionInasistencias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::updateCancelacionInasistencias',  '_route' => 'ActualizarCancelacionInasistencias',);
                    }
                    not_ActualizarCancelacionInasistencias:

                }

                // justificarFaltasbyalumno
                if ($pathinfo === '/api/Asistencia/Justificacion') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_justificarFaltasbyalumno;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::justificarFaltasbyalumno',  '_route' => 'justificarFaltasbyalumno',);
                }
                not_justificarFaltasbyalumno:

                // getReporteAsistencia
                if (rtrim($pathinfo, '/') === '/api/Asistencia/ReporteAsistencia') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getReporteAsistencia;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'getReporteAsistencia');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaController::descargarReporteAsistencia',  '_route' => 'getReporteAsistencia',);
                }
                not_getReporteAsistencia:

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/ControlEscolar/AsistenciaDiaria')) {
                    // indexAsistenciaDiaria
                    if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexAsistenciaDiaria;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::indexAsistenciaDiaria',  '_route' => 'indexAsistenciaDiaria',);
                    }
                    not_indexAsistenciaDiaria:

                    // ConsultarAsistenciaDiarias
                    if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria/Consultar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ConsultarAsistenciaDiarias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::ConsultarAsistenciaDiarias',  '_route' => 'ConsultarAsistenciaDiarias',);
                    }
                    not_ConsultarAsistenciaDiarias:

                    // updateAsistenciaDiaria
                    if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria/Estatus') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateAsistenciaDiaria;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::updateAsistenciaDiaria',  '_route' => 'updateAsistenciaDiaria',);
                    }
                    not_updateAsistenciaDiaria:

                    // ignorarSuspension
                    if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria/ignorarSuspension') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ignorarSuspension;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::ignorarSuspension',  '_route' => 'ignorarSuspension',);
                    }
                    not_ignorarSuspension:

                    if (0 === strpos($pathinfo, '/api/ControlEscolar/AsistenciaDiaria/setSuspension')) {
                        // setSuspension
                        if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria/setSuspension') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_setSuspension;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::setSuspension',  '_route' => 'setSuspension',);
                        }
                        not_setSuspension:

                        // setSuspensionAlumnos
                        if ($pathinfo === '/api/ControlEscolar/AsistenciaDiaria/setSuspensionAlumnos') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_setSuspensionAlumnos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::setSuspensionAlumnos',  '_route' => 'setSuspensionAlumnos',);
                        }
                        not_setSuspensionAlumnos:

                    }

                    // ReporteAsistenciaDiaria
                    if (rtrim($pathinfo, '/') === '/api/ControlEscolar/AsistenciaDiaria/ReporteAsistenciaDiaria') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteAsistenciaDiaria;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'ReporteAsistenciaDiaria');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AsistenciaDiariaController::ReporteAsistenciaDiaria',  '_route' => 'ReporteAsistenciaDiaria',);
                    }
                    not_ReporteAsistenciaDiaria:

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Av')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/AvanceCalificaciones')) {
                            // getAvancecalificacionesFilter
                            if ($pathinfo === '/api/Controlescolar/AvanceCalificaciones/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getAvancecalificacionesFilter;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvanceCalificacionesController::getAvancecalificacionesFilter',  '_route' => 'getAvancecalificacionesFilter',);
                            }
                            not_getAvancecalificacionesFilter:

                            // getAvanceCalificacionesConsulta
                            if ($pathinfo === '/api/Controlescolar/AvanceCalificaciones') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getAvanceCalificacionesConsulta;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvanceCalificacionesController::getAvanceCalificacionesConsulta',  '_route' => 'getAvanceCalificacionesConsulta',);
                            }
                            not_getAvanceCalificacionesConsulta:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/AvisoPlataforma')) {
                            // indexAvisoPlataforma
                            if ($pathinfo === '/api/Controlescolar/AvisoPlataforma') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexAvisoPlataforma;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvisoPlataformaController::indexAvisoPlataforma',  '_route' => 'indexAvisoPlataforma',);
                            }
                            not_indexAvisoPlataforma:

                            // BuscarAvisos
                            if ($pathinfo === '/api/Controlescolar/AvisoPlataforma/Filtrar') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarAvisos;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvisoPlataformaController::getAvisos',  '_route' => 'BuscarAvisos',);
                            }
                            not_BuscarAvisos:

                            // SaveAvisoPlataforma
                            if ($pathinfo === '/api/Controlescolar/AvisoPlataforma/SaveAvisoPlataforma') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_SaveAvisoPlataforma;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvisoPlataformaController::SaveAvisoPlataforma',  '_route' => 'SaveAvisoPlataforma',);
                            }
                            not_SaveAvisoPlataforma:

                            // ObtenerAvisoArchivo
                            if (0 === strpos($pathinfo, '/api/Controlescolar/AvisoPlataforma/DescargarArchivo') && preg_match('#^/api/Controlescolar/AvisoPlataforma/DescargarArchivo/(?P<archivoid>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_ObtenerAvisoArchivo;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerAvisoArchivo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvisoPlataformaController::ObtenerAvisoArchivo',));
                            }
                            not_ObtenerAvisoArchivo:

                            // deleteAvisoPlataforma
                            if (0 === strpos($pathinfo, '/api/Controlescolar/AvisoPlataforma/EliminarAviso') && preg_match('#^/api/Controlescolar/AvisoPlataforma/EliminarAviso/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteAvisoPlataforma;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteAvisoPlataforma')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\AvisoPlataformaController::deleteAvisoPlataforma',));
                            }
                            not_deleteAvisoPlataforma:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/B')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Bitacoracalificaciones')) {
                            // indexBitacora
                            if ($pathinfo === '/api/Controlescolar/Bitacoracalificaciones') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexBitacora;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BitacoraCalificacionesController::indexBitacora',  '_route' => 'indexBitacora',);
                            }
                            not_indexBitacora:

                            // loadPeriodobitacora
                            if ($pathinfo === '/api/Controlescolar/Bitacoracalificaciones/Periodo') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_loadPeriodobitacora;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BitacoraCalificacionesController::loadPeriodobitacora',  '_route' => 'loadPeriodobitacora',);
                            }
                            not_loadPeriodobitacora:

                            // loadAspectoTarea
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/Bitacoracalificaciones/Aspectos') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_loadAspectoTarea;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'loadAspectoTarea');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BitacoraCalificacionesController::loadAspectoTarea',  '_route' => 'loadAspectoTarea',);
                            }
                            not_loadAspectoTarea:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Boleta')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Boletaimpresion')) {
                                // getBIFilter
                                if ($pathinfo === '/api/Controlescolar/Boletaimpresion/filter') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBIFilter;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletaImpresionController::getBIFilter',  '_route' => 'getBIFilter',);
                                }
                                not_getBIFilter:

                                // getBIPDFByAlumno
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Boletaimpresion/alumno') && preg_match('#^/api/Controlescolar/Boletaimpresion/alumno/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBIPDFByAlumno;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getBIPDFByAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletaImpresionController::getBIPDFByAlumno',));
                                }
                                not_getBIPDFByAlumno:

                                // getBIPDF
                                if (rtrim($pathinfo, '/') === '/api/Controlescolar/Boletaimpresion') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBIPDF;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'getBIPDF');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletaImpresionController::getBIPDF',  '_route' => 'getBIPDF',);
                                }
                                not_getBIPDF:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Boletas')) {
                                // getBFilter
                                if ($pathinfo === '/api/Controlescolar/Boletas/filter') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBFilter;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::getBFilter',  '_route' => 'getBFilter',);
                                }
                                not_getBFilter:

                                // getBoletas
                                if ($pathinfo === '/api/Controlescolar/Boletas') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBoletas;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::getBoletas',  '_route' => 'getBoletas',);
                                }
                                not_getBoletas:

                                // deleteBoletas
                                if (preg_match('#^/api/Controlescolar/Boletas/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'DELETE') {
                                        $allow[] = 'DELETE';
                                        goto not_deleteBoletas;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteBoletas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::deleteBoletas',));
                                }
                                not_deleteBoletas:

                                // SaveBoletas
                                if ($pathinfo === '/api/Controlescolar/Boletas') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_SaveBoletas;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::SaveBoletas',  '_route' => 'SaveBoletas',);
                                }
                                not_SaveBoletas:

                                // updateBoleta
                                if (preg_match('#^/api/Controlescolar/Boletas/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_updateBoleta;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateBoleta')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::updateBoleta',));
                                }
                                not_updateBoleta:

                                // getBoletaJasper
                                if (preg_match('#^/api/Controlescolar/Boletas/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getBoletaJasper;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getBoletaJasper')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\BoletasController::getBoletaJasper',));
                                }
                                not_getBoletaJasper:

                            }

                        }

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/Evento')) {
                // InicioEvento
                if ($pathinfo === '/api/Evento') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_InicioEvento;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::indexEvento',  '_route' => 'InicioEvento',);
                }
                not_InicioEvento:

                // buscarEvento
                if (rtrim($pathinfo, '/') === '/api/Evento') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_buscarEvento;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'buscarEvento');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::buscarEvento',  '_route' => 'buscarEvento',);
                }
                not_buscarEvento:

            }

            // BuscarCalendarioAlumno
            if ($pathinfo === '/api/portalalumno/calendario') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_BuscarCalendarioAlumno;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::getCalendarioAlumno',  '_route' => 'BuscarCalendarioAlumno',);
            }
            not_BuscarCalendarioAlumno:

            // DescargarImagenEvento
            if (0 === strpos($pathinfo, '/api/Controlescolar/Evento/Imagen') && preg_match('#^/api/Controlescolar/Evento/Imagen/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_DescargarImagenEvento;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarImagenEvento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::ImagenEvento',));
            }
            not_DescargarImagenEvento:

            if (0 === strpos($pathinfo, '/api/Evento')) {
                // SaveEvento
                if ($pathinfo === '/api/Evento') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_SaveEvento;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::SaveEvento',  '_route' => 'SaveEvento',);
                }
                not_SaveEvento:

                // ActualizarEvento
                if (preg_match('#^/api/Evento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarEvento;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEvento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::updateEvento',));
                }
                not_ActualizarEvento:

                // EliminarEvento
                if (preg_match('#^/api/Evento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarEvento;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEvento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::deleteEvento',));
                }
                not_EliminarEvento:

                // destinatariosEvento
                if (0 === strpos($pathinfo, '/api/Evento/Destinatarios') && preg_match('#^/api/Evento/Destinatarios/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_destinatariosEvento;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'destinatariosEvento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::destinatariosEvento',));
                }
                not_destinatariosEvento:

                // EnvioEventoNotificacion
                if ($pathinfo === '/api/Evento/Notificacion/Envio') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_EnvioEventoNotificacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalendaroEscolarController::EnvioEventoNotificacion',  '_route' => 'EnvioEventoNotificacion',);
                }
                not_EnvioEventoNotificacion:

            }

            if (0 === strpos($pathinfo, '/api/C')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar/C')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Ca')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/CalificacionExtraordinario')) {
                            // getFilterCalificacionExtraordinario
                            if ($pathinfo === '/api/Controlescolar/CalificacionExtraordinario/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getFilterCalificacionExtraordinario;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalificacionExtraordinarioController::getFilterCalificacionExtraordinario',  '_route' => 'getFilterCalificacionExtraordinario',);
                            }
                            not_getFilterCalificacionExtraordinario:

                            // getCalificacionExtraordinario
                            if ($pathinfo === '/api/Controlescolar/CalificacionExtraordinario') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getCalificacionExtraordinario;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalificacionExtraordinarioController::getCalificacionExtraordinario',  '_route' => 'getCalificacionExtraordinario',);
                            }
                            not_getCalificacionExtraordinario:

                            // updateCalificacionExtraordinario
                            if (preg_match('#^/api/Controlescolar/CalificacionExtraordinario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateCalificacionExtraordinario;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateCalificacionExtraordinario')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CalificacionExtraordinarioController::updateCalificacionExtraordinario',));
                            }
                            not_updateCalificacionExtraordinario:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacion')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacionReporte')) {
                                // getReporteDGBCalificacionesByGrupo
                                if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacionReporte/Calificaciones') && preg_match('#^/api/Controlescolar/CapturaCalificacionReporte/Calificaciones/(?P<isgrupo>[^/]++)/(?P<kgruporaw>[^/]++)/(?P<kppmpe>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getReporteDGBCalificacionesByGrupo;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getReporteDGBCalificacionesByGrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionReporteController::getReporteDGBCalificacionesByGrupo',));
                                }
                                not_getReporteDGBCalificacionesByGrupo:

                                // getReporteUltimasFaltasByGrupo
                                if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacionReporte/Faltas') && preg_match('#^/api/Controlescolar/CapturaCalificacionReporte/Faltas/(?P<isgrupo>[^/]++)/(?P<kgruporaw>[^/]++)/(?P<kppmpe>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getReporteUltimasFaltasByGrupo;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getReporteUltimasFaltasByGrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionReporteController::getReporteUltimasFaltasByGrupo',));
                                }
                                not_getReporteUltimasFaltasByGrupo:

                            }

                            // CCCapturaCalificacionGrupo
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/Grupo') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_CCCapturaCalificacionGrupo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::CCCapturaCalificacionGrupo',  '_route' => 'CCCapturaCalificacionGrupo',);
                            }
                            not_CCCapturaCalificacionGrupo:

                            // CCCapturaCalificacionAlumno
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/Alumno') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_CCCapturaCalificacionAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::CCCapturaCalificacionAlumno',  '_route' => 'CCCapturaCalificacionAlumno',);
                            }
                            not_CCCapturaCalificacionAlumno:

                            // CapturaCalificacionDescargar
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/Descargar') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_CapturaCalificacionDescargar;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::CapturaCalificacionDescargar',  '_route' => 'CapturaCalificacionDescargar',);
                            }
                            not_CapturaCalificacionDescargar:

                            // CCGuardarCalificacion
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion') {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_CCGuardarCalificacion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::GuardarCalificacion',  '_route' => 'CCGuardarCalificacion',);
                            }
                            not_CCGuardarCalificacion:

                            // ActualizarOpcion
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/ActualizarOpcion') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_ActualizarOpcion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::ActualizarOpcion',  '_route' => 'ActualizarOpcion',);
                            }
                            not_ActualizarOpcion:

                            // ActualizarCapturaGeneral
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/CapturaGeneral') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_ActualizarCapturaGeneral;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::ActualizarCapturaGeneral',  '_route' => 'ActualizarCapturaGeneral',);
                            }
                            not_ActualizarCapturaGeneral:

                            // getCCCalificacionesByAlumnoKardex
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/CapturaCalificacion/kardex') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getCCCalificacionesByAlumnoKardex;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'getCCCalificacionesByAlumnoKardex');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::getCCCalificacionesByAlumnoKardex',  '_route' => 'getCCCalificacionesByAlumnoKardex',);
                            }
                            not_getCCCalificacionesByAlumnoKardex:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacion/alumno')) {
                                // getCCCalificacionesByAlumnos
                                if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/alumno') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getCCCalificacionesByAlumnos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::getCCCalificacionesByAlumnos',  '_route' => 'getCCCalificacionesByAlumnos',);
                                }
                                not_getCCCalificacionesByAlumnos:

                                // getCCCalificacionesByAlumno
                                if (preg_match('#^/api/Controlescolar/CapturaCalificacion/alumno/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getCCCalificacionesByAlumno;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCCCalificacionesByAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::getCCCalificacionesByAlumno',));
                                }
                                not_getCCCalificacionesByAlumno:

                            }

                            // getCCCalificacionFinalByAlumnociclo
                            if (0 === strpos($pathinfo, '/api/Controlescolar/CapturaCalificacion/final') && preg_match('#^/api/Controlescolar/CapturaCalificacion/final/(?P<alumnoporcicloid>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getCCCalificacionFinalByAlumnociclo;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCCCalificacionFinalByAlumnociclo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::getCCCalificacionFinalByAlumnociclo',));
                            }
                            not_getCCCalificacionFinalByAlumnociclo:

                            // getBitacoraCalificaciones
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/CapturaCalificacion/bitacora') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getBitacoraCalificaciones;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'getBitacoraCalificaciones');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::getBitacoraCapturaCalificacion',  '_route' => 'getBitacoraCalificaciones',);
                            }
                            not_getBitacoraCalificaciones:

                            // getRecalcularCalificaciones
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/ReCalcularCalificaciones') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getRecalcularCalificaciones;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::re_calcularCalificaciones',  '_route' => 'getRecalcularCalificaciones',);
                            }
                            not_getRecalcularCalificaciones:

                            // ActualizarCalFinalAlumno
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/UpCalificacionFinalAlumno') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_ActualizarCalFinalAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::ActualizarCalFinalAlumno',  '_route' => 'ActualizarCalFinalAlumno',);
                            }
                            not_ActualizarCalFinalAlumno:

                            // GetCriteriosAlumnoDetail
                            if ($pathinfo === '/api/Controlescolar/CapturaCalificacion/GetCriteriosAlumnoDetail') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GetCriteriosAlumnoDetail;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CapturaCalificacionesController::GetCriteriosAlumnoDetail',  '_route' => 'GetCriteriosAlumnoDetail',);
                            }
                            not_GetCriteriosAlumnoDetail:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Certificacion')) {
                        // indexCertificacion
                        if ($pathinfo === '/api/Controlescolar/Certificacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexCertificacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionController::indexCertificacion',  '_route' => 'indexCertificacion',);
                        }
                        not_indexCertificacion:

                        // getCertificacion
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/Certificacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getCertificacion;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'getCertificacion');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionController::getCertificacion',  '_route' => 'getCertificacion',);
                        }
                        not_getCertificacion:

                        // saveCertificacion
                        if ($pathinfo === '/api/Controlescolar/Certificacion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_saveCertificacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionController::saveCertificacion',  '_route' => 'saveCertificacion',);
                        }
                        not_saveCertificacion:

                        // updateCertificacion
                        if (preg_match('#^/api/Controlescolar/Certificacion/(?P<certificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_updateCertificacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateCertificacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionController::updateCertificacion',));
                        }
                        not_updateCertificacion:

                        // deleteCertificacion
                        if (preg_match('#^/api/Controlescolar/Certificacion/(?P<certificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_deleteCertificacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteCertificacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionController::deleteCertificacion',));
                        }
                        not_deleteCertificacion:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/CertificacionIdiomas')) {
                            // indexCertificacionIdiomas
                            if ($pathinfo === '/api/Controlescolar/CertificacionIdiomas') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexCertificacionIdiomas;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionIdiomasController::indexCertificacionIdiomas',  '_route' => 'indexCertificacionIdiomas',);
                            }
                            not_indexCertificacionIdiomas:

                            // getCertificacionIdiomas
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/CertificacionIdiomas') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getCertificacionIdiomas;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'getCertificacionIdiomas');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionIdiomasController::getCertificacionIdiomas',  '_route' => 'getCertificacionIdiomas',);
                            }
                            not_getCertificacionIdiomas:

                            // saveCertificacionIdiomas
                            if ($pathinfo === '/api/Controlescolar/CertificacionIdiomas') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_saveCertificacionIdiomas;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionIdiomasController::saveCertificacionIdiomas',  '_route' => 'saveCertificacionIdiomas',);
                            }
                            not_saveCertificacionIdiomas:

                            // updateCertificacionIdiomas
                            if (preg_match('#^/api/Controlescolar/CertificacionIdiomas/(?P<idiomacertificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateCertificacionIdiomas;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateCertificacionIdiomas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionIdiomasController::updateCertificacionIdiomas',));
                            }
                            not_updateCertificacionIdiomas:

                            // deleteCertificacionIdiomas
                            if (preg_match('#^/api/Controlescolar/CertificacionIdiomas/(?P<idiomacertificacionid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteCertificacionIdiomas;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteCertificacionIdiomas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CertificacionIdiomasController::deleteCertificacionIdiomas',));
                            }
                            not_deleteCertificacionIdiomas:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Ciclo')) {
                        // indexCiclo
                        if ($pathinfo === '/api/Controlescolar/Ciclo') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexCiclo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::indexCiclo',  '_route' => 'indexCiclo',);
                        }
                        not_indexCiclo:

                        // BuscarCiclo
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/Ciclo') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarCiclo;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarCiclo');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::getCiclo',  '_route' => 'BuscarCiclo',);
                        }
                        not_BuscarCiclo:

                        // GuardarCiclo
                        if ($pathinfo === '/api/Controlescolar/Ciclo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarCiclo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::SaveCiclo',  '_route' => 'GuardarCiclo',);
                        }
                        not_GuardarCiclo:

                        // ActualizaCiclo
                        if (preg_match('#^/api/Controlescolar/Ciclo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizaCiclo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizaCiclo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::updateCiclo',));
                        }
                        not_ActualizaCiclo:

                        // CambioCiclo
                        if ($pathinfo === '/api/Controlescolar/Ciclo/Cambio') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CambioCiclo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::changeCiclo',  '_route' => 'CambioCiclo',);
                        }
                        not_CambioCiclo:

                        // EliminarCiclo
                        if (preg_match('#^/api/Controlescolar/Ciclo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarCiclo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCiclo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CicloController::deleteCiclo',));
                        }
                        not_EliminarCiclo:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Ciudad')) {
                    // indexCiudad
                    if ($pathinfo === '/api/Ciudad') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexCiudad;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::indexCiudad',  '_route' => 'indexCiudad',);
                    }
                    not_indexCiudad:

                    // BuscarCiudad
                    if (rtrim($pathinfo, '/') === '/api/Ciudad') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarCiudad;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarCiudad');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::getEstado',  '_route' => 'BuscarCiudad',);
                    }
                    not_BuscarCiudad:

                    // BuscarCiudadById
                    if (preg_match('#^/api/Ciudad/(?P<idestado>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarCiudadById;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarCiudadById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::getCiudadBy',));
                    }
                    not_BuscarCiudadById:

                    // EliminarCiudad
                    if (preg_match('#^/api/Ciudad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarCiudad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCiudad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::deleteCiudad',));
                    }
                    not_EliminarCiudad:

                    // GuardarCiudad
                    if ($pathinfo === '/api/Ciudad') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarCiudad;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::SaveCiudad',  '_route' => 'GuardarCiudad',);
                    }
                    not_GuardarCiudad:

                    // ActualizarCiudad
                    if (preg_match('#^/api/Ciudad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarCiudad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarCiudad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CiudadController::updateCiudad',));
                    }
                    not_ActualizarCiudad:

                }

                if (0 === strpos($pathinfo, '/api/Co')) {
                    if (0 === strpos($pathinfo, '/api/Colonia')) {
                        // indexColonia
                        if ($pathinfo === '/api/Colonia') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexColonia;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::indexColonia',  '_route' => 'indexColonia',);
                        }
                        not_indexColonia:

                        // BuscarColonias
                        if (rtrim($pathinfo, '/') === '/api/Colonia') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarColonias;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarColonias');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::getColonias',  '_route' => 'BuscarColonias',);
                        }
                        not_BuscarColonias:

                        // BuscarColoniaByIdCiudad
                        if (preg_match('#^/api/Colonia/(?P<idciudad>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarColoniaByIdCiudad;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarColoniaByIdCiudad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::getColoniasBy',));
                        }
                        not_BuscarColoniaByIdCiudad:

                        // BuscarColoniasByCP
                        if (0 === strpos($pathinfo, '/api/Colonia/GetByCP') && preg_match('#^/api/Colonia/GetByCP/(?P<cp>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarColoniasByCP;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarColoniasByCP')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::getColoniasByCP',));
                        }
                        not_BuscarColoniasByCP:

                        // EliminarColonia
                        if (preg_match('#^/api/Colonia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarColonia;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarColonia')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::deleteCiudad',));
                        }
                        not_EliminarColonia:

                        // GuardarColonia
                        if ($pathinfo === '/api/Colonia') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarColonia;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::SaveColonia',  '_route' => 'GuardarColonia',);
                        }
                        not_GuardarColonia:

                        // ActualizarColonia
                        if (preg_match('#^/api/Colonia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarColonia;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarColonia')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ColoniaController::updateColonia',));
                        }
                        not_ActualizarColonia:

                    }

                    if (0 === strpos($pathinfo, '/api/Con')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Co')) {
                                if (0 === strpos($pathinfo, '/api/Controlescolar/ComponenteCurricular')) {
                                    // EliminarComponenteCurricular
                                    if (preg_match('#^/api/Controlescolar/ComponenteCurricular/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'DELETE') {
                                            $allow[] = 'DELETE';
                                            goto not_EliminarComponenteCurricular;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarComponenteCurricular')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ComponenteCurricularController::deleteComponenteCurricular',));
                                    }
                                    not_EliminarComponenteCurricular:

                                    // BuscarComponenteCurricular
                                    if ($pathinfo === '/api/Controlescolar/ComponenteCurricular/Filtrar') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_BuscarComponenteCurricular;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ComponenteCurricularController::getComponenteCurricular',  '_route' => 'BuscarComponenteCurricular',);
                                    }
                                    not_BuscarComponenteCurricular:

                                    // GuardarComponenteCurricular
                                    if ($pathinfo === '/api/Controlescolar/ComponenteCurricular') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_GuardarComponenteCurricular;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ComponenteCurricularController::SaveComponenteCurricular',  '_route' => 'GuardarComponenteCurricular',);
                                    }
                                    not_GuardarComponenteCurricular:

                                    // indexComponenteCurricular
                                    if (rtrim($pathinfo, '/') === '/api/Controlescolar/ComponenteCurricular') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_indexComponenteCurricular;
                                        }

                                        if (substr($pathinfo, -1) !== '/') {
                                            return $this->redirect($pathinfo.'/', 'indexComponenteCurricular');
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ComponenteCurricularController::indexComponenteCurricular',  '_route' => 'indexComponenteCurricular',);
                                    }
                                    not_indexComponenteCurricular:

                                }

                                if (0 === strpos($pathinfo, '/api/Controlescolar/Con')) {
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Conductacaptura')) {
                                        // getCCFilter
                                        if ($pathinfo === '/api/Controlescolar/Conductacaptura/filter') {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_getCCFilter;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConductaCapturaController::getCCFilter',  '_route' => 'getCCFilter',);
                                        }
                                        not_getCCFilter:

                                        // getCCAlumnos
                                        if (preg_match('#^/api/Controlescolar/Conductacaptura/(?P<grupoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_getCCAlumnos;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCCAlumnos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConductaCapturaController::getCCAlumnos',));
                                        }
                                        not_getCCAlumnos:

                                        // getCCDatos
                                        if (preg_match('#^/api/Controlescolar/Conductacaptura/(?P<periodoevaluacionid>[^/]++)/(?P<alumnocicloporgrupoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_getCCDatos;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCCDatos')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConductaCapturaController::getCCDatos',));
                                        }
                                        not_getCCDatos:

                                        // getCCDatosGrupo
                                        if (preg_match('#^/api/Controlescolar/Conductacaptura/(?P<periodoevaluacionid>[^/]++)/grupo/(?P<grupoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_getCCDatosGrupo;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCCDatosGrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConductaCapturaController::getCCDatosGrupo',));
                                        }
                                        not_getCCDatosGrupo:

                                        // setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo
                                        if (preg_match('#^/api/Controlescolar/Conductacaptura/(?P<periodoevaluacionid>[^/]++)/(?P<alumnocicloporgrupoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'PUT') {
                                                $allow[] = 'PUT';
                                                goto not_setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConductaCapturaController::setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo',));
                                        }
                                        not_setCCCalificacionByPeriodoevaluacionAlumnocicloporgrupo:

                                    }

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/ConfMetasInscripcion')) {
                                        // ConfMetasInscripcion
                                        if ($pathinfo === '/api/Controlescolar/ConfMetasInscripcion') {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_ConfMetasInscripcion;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfMetasInscripcionController::ConfMetasInscripcion',  '_route' => 'ConfMetasInscripcion',);
                                        }
                                        not_ConfMetasInscripcion:

                                        // getMetas
                                        if ($pathinfo === '/api/Controlescolar/ConfMetasInscripcion/getMetas') {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_getMetas;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfMetasInscripcionController::getMetas',  '_route' => 'getMetas',);
                                        }
                                        not_getMetas:

                                        // GuardarMetas
                                        if ($pathinfo === '/api/Controlescolar/ConfMetasInscripcion/Guardar') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_GuardarMetas;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfMetasInscripcionController::GuardarMetas',  '_route' => 'GuardarMetas',);
                                        }
                                        not_GuardarMetas:

                                    }

                                }

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/conftaller')) {
                                if (0 === strpos($pathinfo, '/api/Controlescolar/conftallercurricular')) {
                                    // indexConfTaller
                                    if ($pathinfo === '/api/Controlescolar/conftallercurricular') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_indexConfTaller;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerCurricularController::indexConfTaller',  '_route' => 'indexConfTaller',);
                                    }
                                    not_indexConfTaller:

                                    // SaveConfcurricular
                                    if ($pathinfo === '/api/Controlescolar/conftallercurricular') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_SaveConfcurricular;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerCurricularController::SaveConfcurricular',  '_route' => 'SaveConfcurricular',);
                                    }
                                    not_SaveConfcurricular:

                                }

                                if (0 === strpos($pathinfo, '/api/Controlescolar/conftallerextracurricular')) {
                                    // indexConfTallerExtra
                                    if ($pathinfo === '/api/Controlescolar/conftallerextracurricular') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_indexConfTallerExtra;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::indexConfTallerExtra',  '_route' => 'indexConfTallerExtra',);
                                    }
                                    not_indexConfTallerExtra:

                                    // SaveConfExtracurricular
                                    if ($pathinfo === '/api/Controlescolar/conftallerextracurricular') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_SaveConfExtracurricular;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::SaveConfExtracurricular',  '_route' => 'SaveConfExtracurricular',);
                                    }
                                    not_SaveConfExtracurricular:

                                    // DescargarReglamento
                                    if (preg_match('#^/api/Controlescolar/conftallerextracurricular/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_DescargarReglamento;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarReglamento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::DescargarReglamento',));
                                    }
                                    not_DescargarReglamento:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/conftallerextracurricular/Archivo')) {
                                        // SaveArchivoreglamento
                                        if ($pathinfo === '/api/Controlescolar/conftallerextracurricular/Archivo') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_SaveArchivoreglamento;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::SaveArchivoreglamento',  '_route' => 'SaveArchivoreglamento',);
                                        }
                                        not_SaveArchivoreglamento:

                                        // putArchivoreglamento
                                        if (preg_match('#^/api/Controlescolar/conftallerextracurricular/Archivo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'PUT') {
                                                $allow[] = 'PUT';
                                                goto not_putArchivoreglamento;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'putArchivoreglamento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::putArchivoreglamento',));
                                        }
                                        not_putArchivoreglamento:

                                        // deleteArchivoreglamento
                                        if (preg_match('#^/api/Controlescolar/conftallerextracurricular/Archivo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'DELETE') {
                                                $allow[] = 'DELETE';
                                                goto not_deleteArchivoreglamento;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteArchivoreglamento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::deleteArchivoreglamento',));
                                        }
                                        not_deleteArchivoreglamento:

                                    }

                                    // ObtenerDatosALumno
                                    if ($pathinfo === '/api/Controlescolar/conftallerextracurricular/alumno/') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_ObtenerDatosALumno;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::ObtenerDatosALumno',  '_route' => 'ObtenerDatosALumno',);
                                    }
                                    not_ObtenerDatosALumno:

                                    // eliminarInscripcionAlumnoTaller
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/conftallerextracurricular/eliminarinscripcion') && preg_match('#^/api/Controlescolar/conftallerextracurricular/eliminarinscripcion/(?P<alumnocicloportallerextraid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'DELETE') {
                                            $allow[] = 'DELETE';
                                            goto not_eliminarInscripcionAlumnoTaller;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarInscripcionAlumnoTaller')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::eliminarInscripcionAlumnoTaller',));
                                    }
                                    not_eliminarInscripcionAlumnoTaller:

                                    // guardarInscripcionAlumnoPorTaller
                                    if ($pathinfo === '/api/Controlescolar/conftallerextracurricular/GuardarTallerAlumno') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_guardarInscripcionAlumnoPorTaller;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::guardarInscripcionAlumnoPorTaller',  '_route' => 'guardarInscripcionAlumnoPorTaller',);
                                    }
                                    not_guardarInscripcionAlumnoPorTaller:

                                }

                            }

                            // TallerCicloGradoAlumno
                            if (0 === strpos($pathinfo, '/api/Controlescolar/tallerextracurricular/alumno') && preg_match('#^/api/Controlescolar/tallerextracurricular/alumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_TallerCicloGradoAlumno;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'TallerCicloGradoAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfTallerExtracurricularController::TallerCicloGradoAlumno',));
                            }
                            not_TallerCicloGradoAlumno:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/ConfiguracionHorario')) {
                                // getHorarios
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/getHorarios') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getHorarios;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::getHorarios',  '_route' => 'getHorarios',);
                                }
                                not_getHorarios:

                                // CopiarHorario
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/CopiarHorario') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_CopiarHorario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::CopiarHorario',  '_route' => 'CopiarHorario',);
                                }
                                not_CopiarHorario:

                                // GuardarHorario
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/GuardarHorario') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarHorario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::GuardarHorario',  '_route' => 'GuardarHorario',);
                                }
                                not_GuardarHorario:

                                // deletehorarioconf
                                if (0 === strpos($pathinfo, '/api/Controlescolar/ConfiguracionHorario/DeleteHorario') && preg_match('#^/api/Controlescolar/ConfiguracionHorario/DeleteHorario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'DELETE') {
                                        $allow[] = 'DELETE';
                                        goto not_deletehorarioconf;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletehorarioconf')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::deletehorarioconf',));
                                }
                                not_deletehorarioconf:

                                // getHorarioGrupoMaterias
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/getHorarioGrupoMaterias') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getHorarioGrupoMaterias;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::getHorarioGrupoMaterias',  '_route' => 'getHorarioGrupoMaterias',);
                                }
                                not_getHorarioGrupoMaterias:

                                // GuardarMateriaHorario
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/GuardarMateriaHorario') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarMateriaHorario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::GuardarMateriaHorario',  '_route' => 'GuardarMateriaHorario',);
                                }
                                not_GuardarMateriaHorario:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorario')) {
                                    // deletemateriahorario
                                    if (preg_match('#^/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_deletemateriahorario;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletemateriahorario')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::deletemateriahorario',));
                                    }
                                    not_deletemateriahorario:

                                    // DeleteMateriaHorarioSubgrupoTaller
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorarioSubgrupoTaller') && preg_match('#^/api/Controlescolar/ConfiguracionHorario/DeleteMateriaHorarioSubgrupoTaller/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_DeleteMateriaHorarioSubgrupoTaller;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DeleteMateriaHorarioSubgrupoTaller')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::DeleteMateriaHorarioSubgrupoTaller',));
                                    }
                                    not_DeleteMateriaHorarioSubgrupoTaller:

                                }

                                // checkMateria
                                if (0 === strpos($pathinfo, '/api/Controlescolar/ConfiguracionHorario/CheckMateria') && preg_match('#^/api/Controlescolar/ConfiguracionHorario/CheckMateria/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_checkMateria;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'checkMateria')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::checkMateria',));
                                }
                                not_checkMateria:

                                // GuardarHorariogrupos
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/GuardarHorariogrupos') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_GuardarHorariogrupos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::GuardarHorariogrupos',  '_route' => 'GuardarHorariogrupos',);
                                }
                                not_GuardarHorariogrupos:

                                // checksubgrupoTallerHorario
                                if ($pathinfo === '/api/Controlescolar/ConfiguracionHorario/checksubgrupoTallerHorario') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_checksubgrupoTallerHorario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionHorarioController::checksubgrupoTallerHorario',  '_route' => 'checksubgrupoTallerHorario',);
                                }
                                not_checksubgrupoTallerHorario:

                            }

                        }

                        if (0 === strpos($pathinfo, '/api/ConfiguracionPortal/menus')) {
                            // getMenusConfiguracionportal
                            if ($pathinfo === '/api/ConfiguracionPortal/menus') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getMenusConfiguracionportal;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::getMenusConfiguracionportal',  '_route' => 'getMenusConfiguracionportal',);
                            }
                            not_getMenusConfiguracionportal:

                            if (0 === strpos($pathinfo, '/api/ConfiguracionPortal/menus/set')) {
                                if (0 === strpos($pathinfo, '/api/ConfiguracionPortal/menus/setActivo')) {
                                    // setActivo
                                    if ($pathinfo === '/api/ConfiguracionPortal/menus/setActivo') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_setActivo;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::setActivo',  '_route' => 'setActivo',);
                                    }
                                    not_setActivo:

                                    // setActivoAppConfiguracion
                                    if ($pathinfo === '/api/ConfiguracionPortal/menus/setActivoAppConfiguracion') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_setActivoAppConfiguracion;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::setActivoAppConfiguracion',  '_route' => 'setActivoAppConfiguracion',);
                                    }
                                    not_setActivoAppConfiguracion:

                                }

                                if (0 === strpos($pathinfo, '/api/ConfiguracionPortal/menus/setP')) {
                                    // setPeriodoActivo
                                    if ($pathinfo === '/api/ConfiguracionPortal/menus/setPeriodoActivo') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_setPeriodoActivo;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::setPeriodoActivo',  '_route' => 'setPeriodoActivo',);
                                    }
                                    not_setPeriodoActivo:

                                    // setPortalCalificaciones
                                    if ($pathinfo === '/api/ConfiguracionPortal/menus/setPortalCalificaciones') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_setPortalCalificaciones;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::setPortalCalificaciones',  '_route' => 'setPortalCalificaciones',);
                                    }
                                    not_setPortalCalificaciones:

                                }

                            }

                            // guardarPeriodo
                            if ($pathinfo === '/api/ConfiguracionPortal/menus/guardarPeriodo') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_guardarPeriodo;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::guardarPeriodo',  '_route' => 'guardarPeriodo',);
                            }
                            not_guardarPeriodo:

                            // deletePeriodo
                            if (0 === strpos($pathinfo, '/api/ConfiguracionPortal/menus/deletePeriodo') && preg_match('#^/api/ConfiguracionPortal/menus/deletePeriodo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deletePeriodo;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletePeriodo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConfiguracionPortalesController::deletePeriodo',));
                            }
                            not_deletePeriodo:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/ConsultaAlumnos')) {
                                // indexMatriculas
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/matriculas') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_indexMatriculas;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::indexMatriculas',  '_route' => 'indexMatriculas',);
                                }
                                not_indexMatriculas:

                                // consultaAlumnos
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_consultaAlumnos;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::consultaAlumnos',  '_route' => 'consultaAlumnos',);
                                }
                                not_consultaAlumnos:

                                // SaveAlumno
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_SaveAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::SaveAlumno',  '_route' => 'SaveAlumno',);
                                }
                                not_SaveAlumno:

                                // egresoAlumno
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/Egreso') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_egresoAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::egresoAlumno',  '_route' => 'egresoAlumno',);
                                }
                                not_egresoAlumno:

                                // bajaAlumno
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/Baja') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_bajaAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::bajaAlumno',  '_route' => 'bajaAlumno',);
                                }
                                not_bajaAlumno:

                                // reactivarAlumno
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/Reactivar') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_reactivarAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::reactivarAlumno',  '_route' => 'reactivarAlumno',);
                                }
                                not_reactivarAlumno:

                                // cambiarGradoAlumno
                                if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/CambiarGrado') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_cambiarGradoAlumno;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::cambiarGradoAlumno',  '_route' => 'cambiarGradoAlumno',);
                                }
                                not_cambiarGradoAlumno:

                                if (0 === strpos($pathinfo, '/api/Controlescolar/ConsultaAlumnos/Personarecoge')) {
                                    // savePersonaautorizadarecoger
                                    if ($pathinfo === '/api/Controlescolar/ConsultaAlumnos/Personarecoge') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_savePersonaautorizadarecoger;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::savePersonaautorizadarecoger',  '_route' => 'savePersonaautorizadarecoger',);
                                    }
                                    not_savePersonaautorizadarecoger:

                                    // getPersonaautorizadarecoger
                                    if (preg_match('#^/api/Controlescolar/ConsultaAlumnos/Personarecoge/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_getPersonaautorizadarecoger;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getPersonaautorizadarecoger')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaAlumnosController::getPersonaautorizadarecoger',));
                                    }
                                    not_getPersonaautorizadarecoger:

                                }

                            }

                            // indexHorarios
                            if ($pathinfo === '/api/Controlescolar/Horarios') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexHorarios;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ConsultaHorariosController::indexHorarios',  '_route' => 'indexHorarios',);
                            }
                            not_indexHorarios:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Cr')) {
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Criterioevaluacion')) {
                                    // indexCriterioEvaluacion
                                    if ($pathinfo === '/api/Controlescolar/Criterioevaluacion') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_indexCriterioEvaluacion;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::indexCriterioEvaluacion',  '_route' => 'indexCriterioEvaluacion',);
                                    }
                                    not_indexCriterioEvaluacion:

                                    // BuscarCriterioEvaluacion
                                    if (rtrim($pathinfo, '/') === '/api/Controlescolar/Criterioevaluacion') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_BuscarCriterioEvaluacion;
                                        }

                                        if (substr($pathinfo, -1) !== '/') {
                                            return $this->redirect($pathinfo.'/', 'BuscarCriterioEvaluacion');
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::getCriterioEvaluacion',  '_route' => 'BuscarCriterioEvaluacion',);
                                    }
                                    not_BuscarCriterioEvaluacion:

                                    // GuardarCriterioEvaluacion
                                    if ($pathinfo === '/api/Controlescolar/Criterioevaluacion') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_GuardarCriterioEvaluacion;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::SaveCriterioEvaluacion',  '_route' => 'GuardarCriterioEvaluacion',);
                                    }
                                    not_GuardarCriterioEvaluacion:

                                    // ActualizarCriterioEvaluacion
                                    if (preg_match('#^/api/Controlescolar/Criterioevaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'PUT') {
                                            $allow[] = 'PUT';
                                            goto not_ActualizarCriterioEvaluacion;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarCriterioEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::updateCriterioEvaluacion',));
                                    }
                                    not_ActualizarCriterioEvaluacion:

                                    // EliminarCriterioEvaluacion
                                    if (preg_match('#^/api/Controlescolar/Criterioevaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'DELETE') {
                                            $allow[] = 'DELETE';
                                            goto not_EliminarCriterioEvaluacion;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarCriterioEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::deleteCriterioEvaluacion',));
                                    }
                                    not_EliminarCriterioEvaluacion:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Criterioevaluacion/Copia')) {
                                        // ClonarCriterioEvaluacionPeriodo
                                        if ($pathinfo === '/api/Controlescolar/Criterioevaluacion/Copiaperiodo') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_ClonarCriterioEvaluacionPeriodo;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::cloneCriterioEvaluacionPeriodo',  '_route' => 'ClonarCriterioEvaluacionPeriodo',);
                                        }
                                        not_ClonarCriterioEvaluacionPeriodo:

                                        // ClonarCriterioEvaluacionCiclo
                                        if ($pathinfo === '/api/Controlescolar/Criterioevaluacion/Copia') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_ClonarCriterioEvaluacionCiclo;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::cloneCriterioEvaluacionCiclo',  '_route' => 'ClonarCriterioEvaluacionCiclo',);
                                        }
                                        not_ClonarCriterioEvaluacionCiclo:

                                    }

                                    // AsignarCriterioEvaluacionCiclo
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/Criterioevaluacion/Asignar') && preg_match('#^/api/Controlescolar/Criterioevaluacion/Asignar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_AsignarCriterioEvaluacionCiclo;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'AsignarCriterioEvaluacionCiclo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CriterioEvaluacionController::planestudiotest',));
                                    }
                                    not_AsignarCriterioEvaluacionCiclo:

                                }

                                if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas')) {
                                    // BuscarTareasAlumnoApp
                                    if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/TareasAlumno') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_BuscarTareasAlumnoApp;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::BuscarTareasAlumnoApp',  '_route' => 'BuscarTareasAlumnoApp',);
                                    }
                                    not_BuscarTareasAlumnoApp:

                                    // DescargaReporteTareas
                                    if (rtrim($pathinfo, '/') === '/api/Controlescolar/CronogramaDeTareas/Reporte') {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_DescargaReporteTareas;
                                        }

                                        if (substr($pathinfo, -1) !== '/') {
                                            return $this->redirect($pathinfo.'/', 'DescargaReporteTareas');
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::DescargaReporteTareas',  '_route' => 'DescargaReporteTareas',);
                                    }
                                    not_DescargaReporteTareas:

                                    // AgregarTareasAlumno
                                    if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/TareaAlumno') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_AgregarTareasAlumno;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::AgregarTareasAlumno',  '_route' => 'AgregarTareasAlumno',);
                                    }
                                    not_AgregarTareasAlumno:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/Vinculos')) {
                                        // EliminarTareasAlumnoVinculo
                                        if (preg_match('#^/api/Controlescolar/CronogramaDeTareas/Vinculos/(?P<tareaalumnovinculoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'DELETE') {
                                                $allow[] = 'DELETE';
                                                goto not_EliminarTareasAlumnoVinculo;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarTareasAlumnoVinculo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::EliminarTareasAlumnoVinculo',));
                                        }
                                        not_EliminarTareasAlumnoVinculo:

                                        // GuardarVinculos
                                        if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/Vinculos') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_GuardarVinculos;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::GuardarVinculos',  '_route' => 'GuardarVinculos',);
                                        }
                                        not_GuardarVinculos:

                                    }

                                    // DatosAlumno
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/DatosAlumno') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/DatosAlumno/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_DatosAlumno;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DatosAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::DatosAlumno',));
                                    }
                                    not_DatosAlumno:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/Alumno')) {
                                        // TareasAlumno
                                        if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/AlumnoGrid') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/AlumnoGrid/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_TareasAlumno;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'TareasAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::TareasAlumno',));
                                        }
                                        not_TareasAlumno:

                                        // AlumnoMaterias
                                        if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/AlumnoMaterias') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/AlumnoMaterias/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_AlumnoMaterias;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'AlumnoMaterias')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::AlumnoMaterias',));
                                        }
                                        not_AlumnoMaterias:

                                    }

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/C')) {
                                        // ActualizaCalificacion
                                        if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/Calificacion') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/Calificacion/(?P<tareaalumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if ($this->context->getMethod() != 'PUT') {
                                                $allow[] = 'PUT';
                                                goto not_ActualizaCalificacion;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizaCalificacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::ActualizaCalificacion',));
                                        }
                                        not_ActualizaCalificacion:

                                        // GuardarComentarios
                                        if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/Comentarios') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_GuardarComentarios;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::GuardarComentarios',  '_route' => 'GuardarComentarios',);
                                        }
                                        not_GuardarComentarios:

                                    }

                                    // BuscarTareasAlumno
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/DetalleTareaAlumnoGrid') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/DetalleTareaAlumnoGrid/(?P<tareaid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_BuscarTareasAlumno;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarTareasAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::BuscarTareasAlumno',));
                                    }
                                    not_BuscarTareasAlumno:

                                    // ComentariosLeido
                                    if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/ComentariosLeido') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_ComentariosLeido;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::ComentariosLeido',  '_route' => 'ComentariosLeido',);
                                    }
                                    not_ComentariosLeido:

                                    // VinculosLeido
                                    if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/VinculosLeido') {
                                        if ($this->context->getMethod() != 'POST') {
                                            $allow[] = 'POST';
                                            goto not_VinculosLeido;
                                        }

                                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::VinculosLeido',  '_route' => 'VinculosLeido',);
                                    }
                                    not_VinculosLeido:

                                    // ObtenerTareaArchivo
                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/TareaArchivo') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/TareaArchivo/(?P<tareaarchivoid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_ObtenerTareaArchivo;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ObtenerTareaArchivo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::ObtenerTareaArchivo',));
                                    }
                                    not_ObtenerTareaArchivo:

                                    // EliminarTareas
                                    if (preg_match('#^/api/Controlescolar/CronogramaDeTareas/(?P<tareaid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if ($this->context->getMethod() != 'DELETE') {
                                            $allow[] = 'DELETE';
                                            goto not_EliminarTareas;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarTareas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::EliminarTareas',));
                                    }
                                    not_EliminarTareas:

                                    if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/DetalleTarea')) {
                                        // AgregarTareas
                                        if ($pathinfo === '/api/Controlescolar/CronogramaDeTareas/DetalleTareaAgregar') {
                                            if ($this->context->getMethod() != 'POST') {
                                                $allow[] = 'POST';
                                                goto not_AgregarTareas;
                                            }

                                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::AgregarTareas',  '_route' => 'AgregarTareas',);
                                        }
                                        not_AgregarTareas:

                                        // BuscarTareas
                                        if (0 === strpos($pathinfo, '/api/Controlescolar/CronogramaDeTareas/DetalleTareaGrid') && preg_match('#^/api/Controlescolar/CronogramaDeTareas/DetalleTareaGrid/(?P<profesorpormateriaplanestudioid>[^/]++)$#s', $pathinfo, $matches)) {
                                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                                goto not_BuscarTareas;
                                            }

                                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarTareas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::BuscarTareas',));
                                        }
                                        not_BuscarTareas:

                                    }

                                    // indexConogramaDeTareas
                                    if (preg_match('#^/api/Controlescolar/CronogramaDeTareas/(?P<profesorpormateriaplanestudioid>[^/]++)$#s', $pathinfo, $matches)) {
                                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                            $allow = array_merge($allow, array('GET', 'HEAD'));
                                            goto not_indexConogramaDeTareas;
                                        }

                                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'indexConogramaDeTareas')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\CronogramaTareasController::ConogramaDeTareas',));
                                    }
                                    not_indexConogramaDeTareas:

                                }

                            }

                        }

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/D')) {
                if (0 === strpos($pathinfo, '/api/Departamento')) {
                    // indexDepartamento
                    if ($pathinfo === '/api/Departamento') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexDepartamento;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DepartamentoController::indexDepartamento',  '_route' => 'indexDepartamento',);
                    }
                    not_indexDepartamento:

                    // EliminarDepartamento
                    if (preg_match('#^/api/Departamento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarDepartamento;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarDepartamento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DepartamentoController::deleteDepartamento',));
                    }
                    not_EliminarDepartamento:

                    // GuardarDepartamento
                    if ($pathinfo === '/api/Departamento') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarDepartamento;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DepartamentoController::SaveDepartamento',  '_route' => 'GuardarDepartamento',);
                    }
                    not_GuardarDepartamento:

                    // ActualizarDepartamento
                    if (preg_match('#^/api/Departamento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarDepartamento;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarDepartamento')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DepartamentoController::updateDepartamento',));
                    }
                    not_ActualizarDepartamento:

                }

                if (0 === strpos($pathinfo, '/api/Directorioescolar')) {
                    // indexDirectorio
                    if ($pathinfo === '/api/Directorioescolar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexDirectorio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DirectorioEscolarController::indexDirectorio',  '_route' => 'indexDirectorio',);
                    }
                    not_indexDirectorio:

                    // SaveDirectorio
                    if ($pathinfo === '/api/Directorioescolar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SaveDirectorio;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DirectorioEscolarController::SaveDirectorio',  '_route' => 'SaveDirectorio',);
                    }
                    not_SaveDirectorio:

                    // ActualizarDirectorio
                    if (preg_match('#^/api/Directorioescolar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarDirectorio;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarDirectorio')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DirectorioEscolarController::updateDirectorio',));
                    }
                    not_ActualizarDirectorio:

                    // EliminarDirectorio
                    if (preg_match('#^/api/Directorioescolar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarDirectorio;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarDirectorio')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DirectorioEscolarController::deleteDirectorio',));
                    }
                    not_EliminarDirectorio:

                }

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/ControlEscolar/DocumentosReinscripcion')) {
                    // indexDocumentosR
                    if ($pathinfo === '/api/ControlEscolar/DocumentosReinscripcion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexDocumentosR;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DocumentosReinscripcionController::indexDocumentosR',  '_route' => 'indexDocumentosR',);
                    }
                    not_indexDocumentosR:

                    // BuscarAlumnosDocumentos
                    if ($pathinfo === '/api/ControlEscolar/DocumentosReinscripcion/Filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarAlumnosDocumentos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DocumentosReinscripcionController::BuscarAlumnosDocumentos',  '_route' => 'BuscarAlumnosDocumentos',);
                    }
                    not_BuscarAlumnosDocumentos:

                    // ActualizarAlumnosDocumentos
                    if ($pathinfo === '/api/ControlEscolar/DocumentosReinscripcion/ActualizarDocumentos') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ActualizarAlumnosDocumentos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\DocumentosReinscripcionController::ActualizarAlumnosDocumentos',  '_route' => 'ActualizarAlumnosDocumentos',);
                    }
                    not_ActualizarAlumnosDocumentos:

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar/EdicionExtemporaneaCalificacion')) {
                    // obtenerFiltrosEEC
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion/filtros') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_obtenerFiltrosEEC;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::obtenerFiltrosEEC',  '_route' => 'obtenerFiltrosEEC',);
                    }
                    not_obtenerFiltrosEEC:

                    // filtraralumnosextemporanea
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion/Alumnos') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_filtraralumnosextemporanea;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::filtraralumnosextemporanea',  '_route' => 'filtraralumnosextemporanea',);
                    }
                    not_filtraralumnosextemporanea:

                    // guardarEdicionExtemporanea
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_guardarEdicionExtemporanea;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::guardarEdicionExtemporanea',  '_route' => 'guardarEdicionExtemporanea',);
                    }
                    not_guardarEdicionExtemporanea:

                    // editarEdicionExtemporanea
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_editarEdicionExtemporanea;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::editarEdicionExtemporanea',  '_route' => 'editarEdicionExtemporanea',);
                    }
                    not_editarEdicionExtemporanea:

                    // filtrarExtemporanea
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion/Filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_filtrarExtemporanea;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::filtrarExtemporanea',  '_route' => 'filtrarExtemporanea',);
                    }
                    not_filtrarExtemporanea:

                    // DetalleAlumnosSolicitudEdicinExtemporanea
                    if (preg_match('#^/api/Controlescolar/EdicionExtemporaneaCalificacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DetalleAlumnosSolicitudEdicinExtemporanea;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DetalleAlumnosSolicitudEdicinExtemporanea')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::DetalleAlumnosSolicitudEdicinExtemporanea',));
                    }
                    not_DetalleAlumnosSolicitudEdicinExtemporanea:

                    // autorizarExtemporanea
                    if ($pathinfo === '/api/Controlescolar/EdicionExtemporaneaCalificacion/dictaminar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_autorizarExtemporanea;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdicionExtemporaneaCalificacionController::autorizarExtemporanea',  '_route' => 'autorizarExtemporanea',);
                    }
                    not_autorizarExtemporanea:

                }

            }

            if (0 === strpos($pathinfo, '/api/Edificio')) {
                // indexEdificio
                if ($pathinfo === '/api/Edificio') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexEdificio;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdificioController::indexEdificio',  '_route' => 'indexEdificio',);
                }
                not_indexEdificio:

                // EliminarEdificio
                if (preg_match('#^/api/Edificio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarEdificio;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEdificio')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdificioController::deleteEdificio',));
                }
                not_EliminarEdificio:

                // GuardarEdificio
                if ($pathinfo === '/api/Edificio') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarEdificio;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdificioController::SaveEdificio',  '_route' => 'GuardarEdificio',);
                }
                not_GuardarEdificio:

                // ActualizarEdificio
                if (preg_match('#^/api/Edificio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarEdificio;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEdificio')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EdificioController::updateEdificio',));
                }
                not_ActualizarEdificio:

            }

            if (0 === strpos($pathinfo, '/api/Controlescolar/Reportes')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar/Reportes/ConsultaCorreosPadres/filtr')) {
                    // filtrosConsultaCorreosPadres
                    if ($pathinfo === '/api/Controlescolar/Reportes/ConsultaCorreosPadres/filtros') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_filtrosConsultaCorreosPadres;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EmailPadresController::filtrosConsultaCorreosPadres',  '_route' => 'filtrosConsultaCorreosPadres',);
                    }
                    not_filtrosConsultaCorreosPadres:

                    // filtrarConsultaCorreosPadres
                    if ($pathinfo === '/api/Controlescolar/Reportes/ConsultaCorreosPadres/filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_filtrarConsultaCorreosPadres;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EmailPadresController::filtrarConsultaCorreosPadres',  '_route' => 'filtrarConsultaCorreosPadres',);
                    }
                    not_filtrarConsultaCorreosPadres:

                }

                // BuscarAlumnosDatos
                if ($pathinfo === '/api/Controlescolar/Reportes/Alumnos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarAlumnosDatos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EmailPadresController::BuscarAlumnosDatos',  '_route' => 'BuscarAlumnosDatos',);
                }
                not_BuscarAlumnosDatos:

            }

            if (0 === strpos($pathinfo, '/api/Estado')) {
                // indexEstado
                if ($pathinfo === '/api/Estado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexEstado;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::indexEstado',  '_route' => 'indexEstado',);
                }
                not_indexEstado:

                // BuscarEstado
                if (rtrim($pathinfo, '/') === '/api/Estado') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarEstado;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarEstado');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::getEstado',  '_route' => 'BuscarEstado',);
                }
                not_BuscarEstado:

                // BuscarEstadoById
                if (preg_match('#^/api/Estado/(?P<idpais>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarEstadoById;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarEstadoById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::getEstadoBy',));
                }
                not_BuscarEstadoById:

                // EliminarEstado
                if (preg_match('#^/api/Estado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarEstado;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEstado')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::deleteEstado',));
                }
                not_EliminarEstado:

                // GuardarEstado
                if ($pathinfo === '/api/Estado') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarEstado;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::SaveEstado',  '_route' => 'GuardarEstado',);
                }
                not_GuardarEstado:

                // ActualizarEstado
                if (preg_match('#^/api/Estado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarEstado;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEstado')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\EstadoController::updateEstado',));
                }
                not_ActualizarEstado:

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Extraordinario')) {
                        // indexExtraordinario
                        if ($pathinfo === '/api/Controlescolar/Extraordinario') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexExtraordinario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::indexExtraordinario',  '_route' => 'indexExtraordinario',);
                        }
                        not_indexExtraordinario:

                        // AsignarAlumnoExtraordinario
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Asignar') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_AsignarAlumnoExtraordinario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::AsignarAlumnoExtraordinario',  '_route' => 'AsignarAlumnoExtraordinario',);
                        }
                        not_AsignarAlumnoExtraordinario:

                        // GetPeriodos
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Periodos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_GetPeriodos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::GetPeriodos',  '_route' => 'GetPeriodos',);
                        }
                        not_GetPeriodos:

                        // getExtraordinario
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Filtrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_getExtraordinario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::getExtraordinario',  '_route' => 'getExtraordinario',);
                        }
                        not_getExtraordinario:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Extraordinario/A')) {
                            // AsignarExtrarordinario
                            if ($pathinfo === '/api/Controlescolar/Extraordinario/Asignar') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_AsignarExtrarordinario;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::AsignarExtrarordinario',  '_route' => 'AsignarExtrarordinario',);
                            }
                            not_AsignarExtrarordinario:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Extraordinario/Acuerdo')) {
                                // saveExtraordinario
                                if ($pathinfo === '/api/Controlescolar/Extraordinario/Acuerdo') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_saveExtraordinario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::saveExtraordinario',  '_route' => 'saveExtraordinario',);
                                }
                                not_saveExtraordinario:

                                // updateExtraordinario
                                if ($pathinfo === '/api/Controlescolar/Extraordinario/Acuerdo') {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_updateExtraordinario;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::updateExtraordinario',  '_route' => 'updateExtraordinario',);
                                }
                                not_updateExtraordinario:

                            }

                        }

                        // sendExtraordinario
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Notificar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_sendExtraordinario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::sendExtraordinario',  '_route' => 'sendExtraordinario',);
                        }
                        not_sendExtraordinario:

                        // setRevalidado
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Revalidado') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_setRevalidado;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::sentRevalidado',  '_route' => 'setRevalidado',);
                        }
                        not_setRevalidado:

                        // setIrregular
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Irregular') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_setIrregular;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::setIrregular',  '_route' => 'setIrregular',);
                        }
                        not_setIrregular:

                        // getExtraorginariosAlumno
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Extraordinario/Alumno') && preg_match('#^/api/Controlescolar/Extraordinario/Alumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getExtraorginariosAlumno;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getExtraorginariosAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::getExtraorginariosAlumno',));
                        }
                        not_getExtraorginariosAlumno:

                        // CheckdispcursoAlumno
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/Extraordinario/Disponibilidad') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_CheckdispcursoAlumno;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'CheckdispcursoAlumno');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::CheckdispcursoAlumno',  '_route' => 'CheckdispcursoAlumno',);
                        }
                        not_CheckdispcursoAlumno:

                        // AgendarAcuerdo
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Acordar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_AgendarAcuerdo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::AgendarAcuerdo',  '_route' => 'AgendarAcuerdo',);
                        }
                        not_AgendarAcuerdo:

                        // Extraordinariopendiente
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Pendiente') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_Extraordinariopendiente;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::Extraordinariopendiente',  '_route' => 'Extraordinariopendiente',);
                        }
                        not_Extraordinariopendiente:

                        // ExtraordinarioAlumnoPendiente
                        if ($pathinfo === '/api/Controlescolar/Extraordinario/Alumno/Pendiente') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_ExtraordinarioAlumnoPendiente;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ExtraordinarioController::ExtraordinarioAlumnoPendiente',  '_route' => 'ExtraordinarioAlumnoPendiente',);
                        }
                        not_ExtraordinarioAlumnoPendiente:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Grupos')) {
                        // indexGrupos
                        if ($pathinfo === '/api/Controlescolar/Grupos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexGrupos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::indexGrupos',  '_route' => 'indexGrupos',);
                        }
                        not_indexGrupos:

                        // BuscarGrupos
                        if ($pathinfo === '/api/Controlescolar/Grupos/Filtrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_BuscarGrupos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::BuscarGrupos',  '_route' => 'BuscarGrupos',);
                        }
                        not_BuscarGrupos:

                        // GuardarGrupo
                        if ($pathinfo === '/api/Controlescolar/Grupos') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarGrupo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::SaveGrupos',  '_route' => 'GuardarGrupo',);
                        }
                        not_GuardarGrupo:

                        // EditarGrupo
                        if (preg_match('#^/api/Controlescolar/Grupos/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_EditarGrupo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EditarGrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::EditGrupos',));
                        }
                        not_EditarGrupo:

                        // EliminarGrupo
                        if (preg_match('#^/api/Controlescolar/Grupos/(?P<GrupoId>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarGrupo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarGrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::deleteGrupo',));
                        }
                        not_EliminarGrupo:

                        // CopiarGruposCiclo
                        if ($pathinfo === '/api/Controlescolar/Grupos/CopiarCiclo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CopiarGruposCiclo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\GrupoController::CopiarGruposCiclo',  '_route' => 'CopiarGruposCiclo',);
                        }
                        not_CopiarGruposCiclo:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/ImportarHorarios')) {
                        // getFiltros
                        if ($pathinfo === '/api/Controlescolar/ImportarHorarios/Filtros') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getFiltros;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::getFiltros',  '_route' => 'getFiltros',);
                        }
                        not_getFiltros:

                        // ImportarHorarios
                        if ($pathinfo === '/api/Controlescolar/ImportarHorarios/ImportarHorarios') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_ImportarHorarios;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::ImportarHorarios',  '_route' => 'ImportarHorarios',);
                        }
                        not_ImportarHorarios:

                        // ProcesarArchivo
                        if ($pathinfo === '/api/Controlescolar/ImportarHorarios/ProcesarArchivo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_ProcesarArchivo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::ProcesarArchivo',  '_route' => 'ProcesarArchivo',);
                        }
                        not_ProcesarArchivo:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/ImportarHorarios/Generar')) {
                            // GenerarArchivoImportacion
                            if ($pathinfo === '/api/Controlescolar/ImportarHorarios/GenerarArchivoImportacion') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GenerarArchivoImportacion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::GenerarArchivoImportacion',  '_route' => 'GenerarArchivoImportacion',);
                            }
                            not_GenerarArchivoImportacion:

                            // GenerarLayout
                            if ($pathinfo === '/api/Controlescolar/ImportarHorarios/GenerarLayout') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GenerarLayout;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::GenerarLayout',  '_route' => 'GenerarLayout',);
                            }
                            not_GenerarLayout:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/ImportarHorarios/TablaHorario')) {
                            // getTablaHorario
                            if ($pathinfo === '/api/Controlescolar/ImportarHorarios/TablaHorario') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getTablaHorario;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::getTablaHorario',  '_route' => 'getTablaHorario',);
                            }
                            not_getTablaHorario:

                            // getTablaHorarioAlumno
                            if ($pathinfo === '/api/Controlescolar/ImportarHorarios/TablaHorarioAlumno') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getTablaHorarioAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ImportarHorariosController::getTablaHorarioAlumno',  '_route' => 'getTablaHorarioAlumno',);
                            }
                            not_getTablaHorarioAlumno:

                        }

                    }

                }

                if (0 === strpos($pathinfo, '/api/ControlEscolar/JuntasPadres')) {
                    // indexJuntasPadres
                    if ($pathinfo === '/api/ControlEscolar/JuntasPadres') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexJuntasPadres;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::indexJuntasPadres',  '_route' => 'indexJuntasPadres',);
                    }
                    not_indexJuntasPadres:

                    // ConsultarJuntaPadre
                    if ($pathinfo === '/api/ControlEscolar/JuntasPadres/Consultar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ConsultarJuntaPadre;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::ConsultarJuntaPadre',  '_route' => 'ConsultarJuntaPadre',);
                    }
                    not_ConsultarJuntaPadre:

                    if (0 === strpos($pathinfo, '/api/ControlEscolar/JuntasPadres/s')) {
                        // saveJunta
                        if ($pathinfo === '/api/ControlEscolar/JuntasPadres/saveJunta') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_saveJunta;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::saveJunta',  '_route' => 'saveJunta',);
                        }
                        not_saveJunta:

                        // setRetardoJuntaAlumnos
                        if ($pathinfo === '/api/ControlEscolar/JuntasPadres/setRetardoJuntaAlumnos') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_setRetardoJuntaAlumnos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::setRetardoJuntaAlumnos',  '_route' => 'setRetardoJuntaAlumnos',);
                        }
                        not_setRetardoJuntaAlumnos:

                    }

                    // ReporteJuntasPadres
                    if (rtrim($pathinfo, '/') === '/api/ControlEscolar/JuntasPadres/ReporteJuntasPadres') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteJuntasPadres;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'ReporteJuntasPadres');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::ReporteJuntasPadres',  '_route' => 'ReporteJuntasPadres',);
                    }
                    not_ReporteJuntasPadres:

                    // updateJuntasPadresEstatus
                    if ($pathinfo === '/api/ControlEscolar/JuntasPadres/Estatus') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateJuntasPadresEstatus;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\JuntasPadresController::updateJuntasPadresEstatus',  '_route' => 'updateJuntasPadresEstatus',);
                    }
                    not_updateJuntasPadresEstatus:

                }

            }

            if (0 === strpos($pathinfo, '/api/Materia')) {
                // consultarmateria
                if (0 === strpos($pathinfo, '/api/Materia/Consultar') && preg_match('#^/api/Materia/Consultar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_consultarmateria;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'consultarmateria')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::consultarmateria',));
                }
                not_consultarmateria:

                // materiatest
                if ($pathinfo === '/api/Materia/Test') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_materiatest;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::materiatest',  '_route' => 'materiatest',);
                }
                not_materiatest:

                // combosMaterias
                if ($pathinfo === '/api/Materia/Combos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_combosMaterias;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::combosMaterias',  '_route' => 'combosMaterias',);
                }
                not_combosMaterias:

                // materiareporte
                if (0 === strpos($pathinfo, '/api/Materia/Reporte') && preg_match('#^/api/Materia/Reporte/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_materiareporte;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'materiareporte')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::materiareporte',));
                }
                not_materiareporte:

                // filtrarmaterias
                if ($pathinfo === '/api/Materia/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_filtrarmaterias;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::filtrarmaterias',  '_route' => 'filtrarmaterias',);
                }
                not_filtrarmaterias:

                // filtrarmateriasnivel
                if ($pathinfo === '/api/Materia/Nivel/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_filtrarmateriasnivel;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::filtrarmateriasnivel',  '_route' => 'filtrarmateriasnivel',);
                }
                not_filtrarmateriasnivel:

                // agregarnuevamateria
                if ($pathinfo === '/api/Materia/AgregarNueva') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_agregarnuevamateria;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::agregarnuevamateria',  '_route' => 'agregarnuevamateria',);
                }
                not_agregarnuevamateria:

                if (0 === strpos($pathinfo, '/api/Materia/E')) {
                    // editarmateria
                    if ($pathinfo === '/api/Materia/Editar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_editarmateria;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::editarmateria',  '_route' => 'editarmateria',);
                    }
                    not_editarmateria:

                    // eliminarmateria
                    if (0 === strpos($pathinfo, '/api/Materia/Eliminar') && preg_match('#^/api/Materia/Eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_eliminarmateria;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarmateria')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MateriaController::eliminarmateria',));
                    }
                    not_eliminarmateria:

                }

            }

            if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases')) {
                    // AMFiltrosMisclasesProfesor
                    if ($pathinfo === '/api/Controlescolar/Misclases') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_AMFiltrosMisclasesProfesor;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::FiltrosMisclasesProfesor',  '_route' => 'AMFiltrosMisclasesProfesor',);
                    }
                    not_AMFiltrosMisclasesProfesor:

                    // BuscarAlumnoListadeasistencia
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Listadeasistencia') && preg_match('#^/api/Controlescolar/Misclases/Listadeasistencia/(?P<profesorpormateriaplanestudioid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarAlumnoListadeasistencia;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAlumnoListadeasistencia')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getAlumnoListadeasistencia',));
                    }
                    not_BuscarAlumnoListadeasistencia:

                    // BuscarMisclases
                    if ($pathinfo === '/api/Controlescolar/Misclases/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarMisclases;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getCriterioEvaluacion',  '_route' => 'BuscarMisclases',);
                    }
                    not_BuscarMisclases:

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase')) {
                        // BuscarCriterioEvaluacionClase
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/Misclases/Criteriosclase') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarCriterioEvaluacionClase;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarCriterioEvaluacionClase');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getCriterioEvaluacionClase',  '_route' => 'BuscarCriterioEvaluacionClase',);
                        }
                        not_BuscarCriterioEvaluacionClase:

                        // GuardarMisclases
                        if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarMisclases;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::saveMisclases',  '_route' => 'GuardarMisclases',);
                        }
                        not_GuardarMisclases:

                        // ActualizarMisclases
                        if (preg_match('#^/api/Controlescolar/Misclases/Criteriosclase/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarMisclases;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarMisclases')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::updateMisclases',));
                        }
                        not_ActualizarMisclases:

                        // EliminarMisclases
                        if (preg_match('#^/api/Controlescolar/Misclases/Criteriosclase/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarMisclases;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarMisclases')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::deleteMisclases',));
                        }
                        not_EliminarMisclases:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Grupo')) {
                        // BuscarGruposProfesor
                        if ($pathinfo === '/api/Controlescolar/Misclases/Grupo') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarGruposProfesor;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getGruposProfesor',  '_route' => 'BuscarGruposProfesor',);
                        }
                        not_BuscarGruposProfesor:

                        // GrupoTareaCopiar
                        if ($pathinfo === '/api/Controlescolar/Misclases/GrupoTareaCopiar') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_GrupoTareaCopiar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::GrupoTareaCopiar',  '_route' => 'GrupoTareaCopiar',);
                        }
                        not_GrupoTareaCopiar:

                        // ClonarMisclases
                        if ($pathinfo === '/api/Controlescolar/Misclases/Grupo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_ClonarMisclases;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::cloneMisclases',  '_route' => 'ClonarMisclases',);
                        }
                        not_ClonarMisclases:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/C')) {
                        // CopiarTarea
                        if ($pathinfo === '/api/Controlescolar/Misclases/CopiarTarea') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CopiarTarea;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::CopiarTarea',  '_route' => 'CopiarTarea',);
                        }
                        not_CopiarTarea:

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase')) {
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase/Tarea')) {
                                // IndexTarea
                                if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase/Tarea') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_IndexTarea;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getTarea',  '_route' => 'IndexTarea',);
                                }
                                not_IndexTarea:

                                // GuardarTarea
                                if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase/Tarea') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarTarea;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::saveTarea',  '_route' => 'GuardarTarea',);
                                }
                                not_GuardarTarea:

                            }

                            // getCaratula
                            if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase/Caratula') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getCaratula;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::getCaratula',  '_route' => 'getCaratula',);
                            }
                            not_getCaratula:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase/Save')) {
                                // SaveCaratula
                                if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase/SaveCaratula') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_SaveCaratula;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::SaveCaratula',  '_route' => 'SaveCaratula',);
                                }
                                not_SaveCaratula:

                                // SaveAvisosCaratula
                                if ($pathinfo === '/api/Controlescolar/Misclases/Criteriosclase/SaveAvisoCaratula') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_SaveAvisosCaratula;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::SaveAvisosCaratula',  '_route' => 'SaveAvisosCaratula',);
                                }
                                not_SaveAvisosCaratula:

                            }

                            // DescargarArchivoCaratula
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase/DescargarArchivoCaratula') && preg_match('#^/api/Controlescolar/Misclases/Criteriosclase/DescargarArchivoCaratula/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_DescargarArchivoCaratula;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarArchivoCaratula')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::DescargarArchivoCaratula',));
                            }
                            not_DescargarArchivoCaratula:

                            // deleteAvisoCaratula
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Misclases/Criteriosclase/EliminarAviso') && preg_match('#^/api/Controlescolar/Misclases/Criteriosclase/EliminarAviso/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteAvisoCaratula;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteAvisoCaratula')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::deleteAvisoCaratula',));
                            }
                            not_deleteAvisoCaratula:

                        }

                    }

                }

                // obtenerMateriasAlumno
                if ($pathinfo === '/api/Controlescolar/Alumno/Misclases/Alumnos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_obtenerMateriasAlumno;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MisClasesController::obtenerMateriasAlumno',  '_route' => 'obtenerMateriasAlumno',);
                }
                not_obtenerMateriasAlumno:

            }

            if (0 === strpos($pathinfo, '/api/Motivobaja')) {
                // indexMotivobaja
                if ($pathinfo === '/api/Motivobaja') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexMotivobaja;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MotivoBajaController::indexMotivobaja',  '_route' => 'indexMotivobaja',);
                }
                not_indexMotivobaja:

                // Motivobajafiltro
                if ($pathinfo === '/api/Motivobaja/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_Motivobajafiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MotivoBajaController::Motivobajafiltro',  '_route' => 'Motivobajafiltro',);
                }
                not_Motivobajafiltro:

                // EliminarMotivobaja
                if (preg_match('#^/api/Motivobaja/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarMotivobaja;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarMotivobaja')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MotivoBajaController::deleteMotivobaja',));
                }
                not_EliminarMotivobaja:

                // GuardarMotivobaja
                if ($pathinfo === '/api/Motivobaja') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarMotivobaja;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MotivoBajaController::SaveMotivobaja',  '_route' => 'GuardarMotivobaja',);
                }
                not_GuardarMotivobaja:

                // ActualizarMotivobaja
                if (preg_match('#^/api/Motivobaja/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarMotivobaja;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarMotivobaja')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\MotivoBajaController::updateMotivobaja',));
                }
                not_ActualizarMotivobaja:

            }

            if (0 === strpos($pathinfo, '/api/N')) {
                if (0 === strpos($pathinfo, '/api/Nacionalidad')) {
                    // indexNacionalidad
                    if (preg_match('#^/api/Nacionalidad/(?P<reload>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexNacionalidad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'indexNacionalidad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NacionalidadController::indexNacionalidad',));
                    }
                    not_indexNacionalidad:

                    // EliminarNacionalidad
                    if (preg_match('#^/api/Nacionalidad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarNacionalidad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarNacionalidad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NacionalidadController::deleteNacionalidad',));
                    }
                    not_EliminarNacionalidad:

                    // GuardarNacionalidad
                    if ($pathinfo === '/api/Nacionalidad') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarNacionalidad;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NacionalidadController::SaveNacionalidad',  '_route' => 'GuardarNacionalidad',);
                    }
                    not_GuardarNacionalidad:

                    // ActualizarNacionalidad
                    if (preg_match('#^/api/Nacionalidad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarNacionalidad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarNacionalidad')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NacionalidadController::updateNacionalidad',));
                    }
                    not_ActualizarNacionalidad:

                }

                if (0 === strpos($pathinfo, '/api/Nivelidioma')) {
                    // indexNivelidioma
                    if ($pathinfo === '/api/Nivelidioma') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexNivelidioma;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NivelIdiomaController::indexNivelidioma',  '_route' => 'indexNivelidioma',);
                    }
                    not_indexNivelidioma:

                    // deleteNivelidioma
                    if (preg_match('#^/api/Nivelidioma/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_deleteNivelidioma;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteNivelidioma')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NivelIdiomaController::deleteNivelidioma',));
                    }
                    not_deleteNivelidioma:

                    // SaveNivelidioma
                    if ($pathinfo === '/api/Nivelidioma') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SaveNivelidioma;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NivelIdiomaController::SaveNivelidioma',  '_route' => 'SaveNivelidioma',);
                    }
                    not_SaveNivelidioma:

                    // updateNivelidioma
                    if (preg_match('#^/api/Nivelidioma/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateNivelidioma;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateNivelidioma')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NivelIdiomaController::updateNivelidioma',));
                    }
                    not_updateNivelidioma:

                }

            }

            if (0 === strpos($pathinfo, '/api/Controlescolar/Notificacion')) {
                // indexNotificacionActividad
                if ($pathinfo === '/api/Controlescolar/Notificacion') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexNotificacionActividad;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NotificacionController::indexNotificacionActividad',  '_route' => 'indexNotificacionActividad',);
                }
                not_indexNotificacionActividad:

                // getNotificacion
                if ($pathinfo === '/api/Controlescolar/Notificacion/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_getNotificacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\NotificacionController::getNotificacion',  '_route' => 'getNotificacion',);
                }
                not_getNotificacion:

            }

            if (0 === strpos($pathinfo, '/api/Ocupacion')) {
                // indexOcupacion
                if ($pathinfo === '/api/Ocupacion') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexOcupacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\OcupacionController::indexOcupaciones',  '_route' => 'indexOcupacion',);
                }
                not_indexOcupacion:

                // GuardarOcupacion
                if ($pathinfo === '/api/Ocupacion') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarOcupacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\OcupacionController::SaveOcupacion',  '_route' => 'GuardarOcupacion',);
                }
                not_GuardarOcupacion:

            }

            if (0 === strpos($pathinfo, '/api/Pais')) {
                // BuscarPais
                if (rtrim($pathinfo, '/') === '/api/Pais') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarPais;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'BuscarPais');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PaisesController::indexPais',  '_route' => 'BuscarPais',);
                }
                not_BuscarPais:

                // EliminarPais
                if (preg_match('#^/api/Pais/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarPais;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPais')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PaisesController::deletePais',));
                }
                not_EliminarPais:

                // GuardarPais
                if ($pathinfo === '/api/Pais') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarPais;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PaisesController::SavePais',  '_route' => 'GuardarPais',);
                }
                not_GuardarPais:

                // ActualizarPais
                if (preg_match('#^/api/Pais/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarPais;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarPais')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PaisesController::updatePais',));
                }
                not_ActualizarPais:

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/Controlescolar/Periodo')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/PeriodoEvaluacion')) {
                        // indexPeriodoEvaluacion
                        if ($pathinfo === '/api/Controlescolar/PeriodoEvaluacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexPeriodoEvaluacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoEvaluacionController::indexPeriodoEvaluacion',  '_route' => 'indexPeriodoEvaluacion',);
                        }
                        not_indexPeriodoEvaluacion:

                        // BuscarPeriodoEvaluacion
                        if (rtrim($pathinfo, '/') === '/api/Controlescolar/PeriodoEvaluacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarPeriodoEvaluacion;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarPeriodoEvaluacion');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoEvaluacionController::getPeriodoEvaluacion',  '_route' => 'BuscarPeriodoEvaluacion',);
                        }
                        not_BuscarPeriodoEvaluacion:

                        // GuardarPeriodoEvaluacion
                        if ($pathinfo === '/api/Controlescolar/PeriodoEvaluacion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarPeriodoEvaluacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoEvaluacionController::SavePeriodoEvaluacion',  '_route' => 'GuardarPeriodoEvaluacion',);
                        }
                        not_GuardarPeriodoEvaluacion:

                        // ActualizaPeriodoEvaluacion
                        if (preg_match('#^/api/Controlescolar/PeriodoEvaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizaPeriodoEvaluacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizaPeriodoEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoEvaluacionController::updatePeriodoEvaluacion',));
                        }
                        not_ActualizaPeriodoEvaluacion:

                        // EliminarPeriodoEvaluacion
                        if (preg_match('#^/api/Controlescolar/PeriodoEvaluacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarPeriodoEvaluacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPeriodoEvaluacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoEvaluacionController::deletePeriodoEvaluacion',));
                        }
                        not_EliminarPeriodoEvaluacion:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/PeriodoRegularizacion')) {
                        // getFilterPeriodoRegularizacion
                        if ($pathinfo === '/api/Controlescolar/PeriodoRegularizacion/filter') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getFilterPeriodoRegularizacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::getFilterPeriodoRegularizacion',  '_route' => 'getFilterPeriodoRegularizacion',);
                        }
                        not_getFilterPeriodoRegularizacion:

                        // getPeriodoRegularizacion
                        if ($pathinfo === '/api/Controlescolar/PeriodoRegularizacion') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getPeriodoRegularizacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::getPeriodoRegularizacion',  '_route' => 'getPeriodoRegularizacion',);
                        }
                        not_getPeriodoRegularizacion:

                        // getPeriodoRegularizacionByID
                        if (preg_match('#^/api/Controlescolar/PeriodoRegularizacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getPeriodoRegularizacionByID;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getPeriodoRegularizacionByID')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::getPeriodoRegularizacionByID',));
                        }
                        not_getPeriodoRegularizacionByID:

                        // createPeriodoRegularizacion
                        if ($pathinfo === '/api/Controlescolar/PeriodoRegularizacion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_createPeriodoRegularizacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::createPeriodoRegularizacion',  '_route' => 'createPeriodoRegularizacion',);
                        }
                        not_createPeriodoRegularizacion:

                        // updatePeriodoRegularizacion
                        if (preg_match('#^/api/Controlescolar/PeriodoRegularizacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_updatePeriodoRegularizacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updatePeriodoRegularizacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::updatePeriodoRegularizacion',));
                        }
                        not_updatePeriodoRegularizacion:

                        // deletePeriodoRegularizacion
                        if (preg_match('#^/api/Controlescolar/PeriodoRegularizacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_deletePeriodoRegularizacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletePeriodoRegularizacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PeriodoRegularizacionController::deletePeriodoRegularizacion',));
                        }
                        not_deletePeriodoRegularizacion:

                    }

                }

                if (0 === strpos($pathinfo, '/api/ControlEscolar/Plan')) {
                    if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio')) {
                        // obtenermateriasplanestudios
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio/Materias') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_obtenermateriasplanestudios;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::obtenermateriasplanestudios',  '_route' => 'obtenermateriasplanestudios',);
                        }
                        not_obtenermateriasplanestudios:

                        // indexPlanestudio
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexPlanestudio;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::indexPlanestudio',  '_route' => 'indexPlanestudio',);
                        }
                        not_indexPlanestudio:

                        // indexPlanestudioMateria
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio/Materia') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexPlanestudioMateria;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::indexPlanestudioMateria',  '_route' => 'indexPlanestudioMateria',);
                        }
                        not_indexPlanestudioMateria:

                        // BuscarPlanestudio
                        if (rtrim($pathinfo, '/') === '/api/ControlEscolar/PlanEstudio') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarPlanestudio;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarPlanestudio');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::getPlanestudio',  '_route' => 'BuscarPlanestudio',);
                        }
                        not_BuscarPlanestudio:

                        // planestudiosguardar
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_planestudiosguardar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::planestudiosguardar',  '_route' => 'planestudiosguardar',);
                        }
                        not_planestudiosguardar:

                        // planestudioseditar
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_planestudioseditar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::planestudioseditar',  '_route' => 'planestudioseditar',);
                        }
                        not_planestudioseditar:

                        // planestudioseliminar
                        if (preg_match('#^/api/ControlEscolar/PlanEstudio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_planestudioseliminar;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'planestudioseliminar')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::planestudioseliminar',));
                        }
                        not_planestudioseliminar:

                        // planestudicopia
                        if ($pathinfo === '/api/ControlEscolar/PlanEstudio/Copia') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_planestudicopia;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::planestudicopia',  '_route' => 'planestudicopia',);
                        }
                        not_planestudicopia:

                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio/Materia')) {
                            // eliminarmateriaplanestudio
                            if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio/Materia/Eliminar') && preg_match('#^/api/ControlEscolar/PlanEstudio/Materia/Eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_eliminarmateriaplanestudio;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarmateriaplanestudio')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::eliminarmateriaplanestudio',));
                            }
                            not_eliminarmateriaplanestudio:

                            // materiasporgrupo
                            if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio/Materias/Filtrar') && preg_match('#^/api/ControlEscolar/PlanEstudio/Materias/Filtrar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_materiasporgrupo;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'materiasporgrupo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::materiasporgrupo',));
                            }
                            not_materiasporgrupo:

                        }

                        // planestudiofiltrar
                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio/Filtrar') && preg_match('#^/api/ControlEscolar/PlanEstudio/Filtrar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_planestudiofiltrar;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'planestudiofiltrar')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::planestudiofiltrar',));
                        }
                        not_planestudiofiltrar:

                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlanEstudio/Materias')) {
                            // agregarmateriasplanestudio
                            if ($pathinfo === '/api/ControlEscolar/PlanEstudio/Materias') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_agregarmateriasplanestudio;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::agregarmateriasplanestudio',  '_route' => 'agregarmateriasplanestudio',);
                            }
                            not_agregarmateriasplanestudio:

                            // editarmateriasplanestudio
                            if ($pathinfo === '/api/ControlEscolar/PlanEstudio/Materias') {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_editarmateriasplanestudio;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlanEstudioController::editarmateriasplanestudio',  '_route' => 'editarmateriasplanestudio',);
                            }
                            not_editarmateriasplanestudio:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores')) {
                        // indexPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Combos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::indexPlantillaProfesores',  '_route' => 'indexPlantillaProfesores',);
                        }
                        not_indexPlantillaProfesores:

                        // FiltrarPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Filtrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_FiltrarPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::FiltrarPlantillaProfesores',  '_route' => 'FiltrarPlantillaProfesores',);
                        }
                        not_FiltrarPlantillaProfesores:

                        // guardarPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_guardarPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::guardarPlantillaProfesores',  '_route' => 'guardarPlantillaProfesores',);
                        }
                        not_guardarPlantillaProfesores:

                        // EliminarPlantillaProfesores
                        if (preg_match('#^/api/ControlEscolar/PlantillaProfesores/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarPlantillaProfesores;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPlantillaProfesores')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::EliminarPlantillaProfesores',));
                        }
                        not_EliminarPlantillaProfesores:

                        // regularPlantillaProfesores
                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores/Regular') && preg_match('#^/api/ControlEscolar/PlantillaProfesores/Regular/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_regularPlantillaProfesores;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'regularPlantillaProfesores')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::regularPlantillaProfesores',));
                        }
                        not_regularPlantillaProfesores:

                        // especialPlantillaProfesores
                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores/Especial') && preg_match('#^/api/ControlEscolar/PlantillaProfesores/Especial/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_especialPlantillaProfesores;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'especialPlantillaProfesores')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::especialPlantillaProfesores',));
                        }
                        not_especialPlantillaProfesores:

                        // guardarDetallePlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Detalle') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_guardarDetallePlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::guardarDetallePlantillaProfesores',  '_route' => 'guardarDetallePlantillaProfesores',);
                        }
                        not_guardarDetallePlantillaProfesores:

                        // validarPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Validar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_validarPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::validarPlantillaProfesores',  '_route' => 'validarPlantillaProfesores',);
                        }
                        not_validarPlantillaProfesores:

                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores/C')) {
                            if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores/Copiar')) {
                                // copiarPlantillaprofesores
                                if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Copiar') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_copiarPlantillaprofesores;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::copiarPlantillaprofesores',  '_route' => 'copiarPlantillaprofesores',);
                                }
                                not_copiarPlantillaprofesores:

                                // copiarPlantillaprofesoressemestre
                                if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Copiarsemestre') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_copiarPlantillaprofesoressemestre;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::copiarPlantillaprofesoressemestre',  '_route' => 'copiarPlantillaprofesoressemestre',);
                                }
                                not_copiarPlantillaprofesoressemestre:

                            }

                            // capturarPlantillaProfesores
                            if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Capturar') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_capturarPlantillaProfesores;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::capturarPlantillaProfesores',  '_route' => 'capturarPlantillaProfesores',);
                            }
                            not_capturarPlantillaProfesores:

                        }

                        // rechazarPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Rechazar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_rechazarPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::rechazarPlantillaProfesores',  '_route' => 'rechazarPlantillaProfesores',);
                        }
                        not_rechazarPlantillaProfesores:

                        // autorizarPlantillaProfesores
                        if ($pathinfo === '/api/ControlEscolar/PlantillaProfesores/Autorizar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_autorizarPlantillaProfesores;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::autorizarPlantillaProfesores',  '_route' => 'autorizarPlantillaProfesores',);
                        }
                        not_autorizarPlantillaProfesores:

                        // ReporteMaestrosMaterias
                        if (0 === strpos($pathinfo, '/api/ControlEscolar/PlantillaProfesores/Reporte') && preg_match('#^/api/ControlEscolar/PlantillaProfesores/Reporte/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_ReporteMaestrosMaterias;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ReporteMaestrosMaterias')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PlantillaProfesorController::ReporteMaestrosMaterias',));
                        }
                        not_ReporteMaestrosMaterias:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar/Ponderacion')) {
                    // BuscarPonderacion
                    if ($pathinfo === '/api/Controlescolar/Ponderacion/Filtrar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarPonderacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PonderacionController::getPonderacion',  '_route' => 'BuscarPonderacion',);
                    }
                    not_BuscarPonderacion:

                    // GuardarPonderacion
                    if ($pathinfo === '/api/Controlescolar/Ponderacion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarPonderacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PonderacionController::SavePonderacion',  '_route' => 'GuardarPonderacion',);
                    }
                    not_GuardarPonderacion:

                    // EliminarPonderacion
                    if (preg_match('#^/api/Controlescolar/Ponderacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarPonderacion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPonderacion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\PonderacionController::deletePonderacion',));
                    }
                    not_EliminarPonderacion:

                }

            }

            if (0 === strpos($pathinfo, '/api/Profesor')) {
                // indexProfesores
                if ($pathinfo === '/api/Profesor') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexProfesores;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::indexProfesor',  '_route' => 'indexProfesores',);
                }
                not_indexProfesores:

                // getProfesorFoto
                if (rtrim($pathinfo, '/') === '/api/Profesor/foto') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getProfesorFoto;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'getProfesorFoto');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::getProfesorFoto',  '_route' => 'getProfesorFoto',);
                }
                not_getProfesorFoto:

                // Profesorfiltro
                if ($pathinfo === '/api/Profesor/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_Profesorfiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::Profesorfiltro',  '_route' => 'Profesorfiltro',);
                }
                not_Profesorfiltro:

                // EliminarProfesor
                if (preg_match('#^/api/Profesor/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_EliminarProfesor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::deleteProfesor',));
                }
                not_EliminarProfesor:

                // ProfesorCombos
                if ($pathinfo === '/api/Profesor/Combos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ProfesorCombos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::ProfesorCombos',  '_route' => 'ProfesorCombos',);
                }
                not_ProfesorCombos:

                // GuardarProfesor
                if ($pathinfo === '/api/Profesor') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarProfesor;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::SaveProfesor',  '_route' => 'GuardarProfesor',);
                }
                not_GuardarProfesor:

                // ActualizarProfesor
                if (preg_match('#^/api/Profesor/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_ActualizarProfesor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::updateProfesor',));
                }
                not_ActualizarProfesor:

                // BuscarEstudiosProfesor
                if (preg_match('#^/api/Profesor/(?P<id>[^/]++)/Estudios$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarEstudiosProfesor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarEstudiosProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::getEstudiosProfesor',));
                }
                not_BuscarEstudiosProfesor:

                // GuardarEstudioProfesor
                if (preg_match('#^/api/Profesor/(?P<id>[^/]++)/Estudios$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarEstudioProfesor;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'GuardarEstudioProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::SaveEstudiosProfesor',));
                }
                not_GuardarEstudioProfesor:

                if (0 === strpos($pathinfo, '/api/Profesor/Estudios')) {
                    // ActualizarEstudioProfesor
                    if (preg_match('#^/api/Profesor/Estudios/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarEstudioProfesor;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarEstudioProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::updateEstudiosProfesor',));
                    }
                    not_ActualizarEstudioProfesor:

                    // EliminarEstudioProfesor
                    if (preg_match('#^/api/Profesor/Estudios/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarEstudioProfesor;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarEstudioProfesor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::deleteEstudioProfesor',));
                    }
                    not_EliminarEstudioProfesor:

                }

                // BuscarProfesores
                if ($pathinfo === '/api/Profesor/Directorio') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_BuscarProfesores;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::getProfesores',  '_route' => 'BuscarProfesores',);
                }
                not_BuscarProfesores:

                // getMateriasprofesorreport
                if (rtrim($pathinfo, '/') === '/api/Profesor/listaMateriasProfesor') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getMateriasprofesorreport;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'getMateriasprofesorreport');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::getMateriasprofesorreport',  '_route' => 'getMateriasprofesorreport',);
                }
                not_getMateriasprofesorreport:

                // getProfesoresReport
                if (0 === strpos($pathinfo, '/api/Profesor/ReporteProfesores') && preg_match('#^/api/Profesor/ReporteProfesores/(?P<profesorid>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getProfesoresReport;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getProfesoresReport')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresController::getProfesoresReport',));
                }
                not_getProfesoresReport:

            }

            if (0 === strpos($pathinfo, '/api/Control')) {
                if (0 === strpos($pathinfo, '/api/ControlEscolar/ProfesorNivel')) {
                    // filtrarprofesornivel
                    if ($pathinfo === '/api/ControlEscolar/ProfesorNivel/Filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_filtrarprofesornivel;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::filtrarprofesornivel',  '_route' => 'filtrarprofesornivel',);
                    }
                    not_filtrarprofesornivel:

                    // obtenerprofesornivel
                    if ($pathinfo === '/api/ControlEscolar/ProfesorNivel/ObtenerFaltantes') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_obtenerprofesornivel;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::obtenerprofesornivel',  '_route' => 'obtenerprofesornivel',);
                    }
                    not_obtenerprofesornivel:

                    // copiarprofesornivel
                    if ($pathinfo === '/api/ControlEscolar/ProfesorNivel/Copiar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_copiarprofesornivel;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::copiarprofesornivel',  '_route' => 'copiarprofesornivel',);
                    }
                    not_copiarprofesornivel:

                    // guardarProfesorNivel
                    if ($pathinfo === '/api/ControlEscolar/ProfesorNivel') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_guardarProfesorNivel;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::guardarProfesorNivel',  '_route' => 'guardarProfesorNivel',);
                    }
                    not_guardarProfesorNivel:

                    // eliminarProfesorNivel
                    if (preg_match('#^/api/ControlEscolar/ProfesorNivel/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_eliminarProfesorNivel;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'eliminarProfesorNivel')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::eliminarProfesorNivel',));
                    }
                    not_eliminarProfesorNivel:

                    // ReporteReprobacion
                    if (rtrim($pathinfo, '/') === '/api/ControlEscolar/ProfesorNivel/ReporteReprobacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteReprobacion;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'ReporteReprobacion');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ProfesoresNivelesController::ReporteReprobacion',  '_route' => 'ReporteReprobacion',);
                    }
                    not_ReporteReprobacion:

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar/Recuperacionperiodo')) {
                    // getRPAlumnosReprobados
                    if ($pathinfo === '/api/Controlescolar/Recuperacionperiodo') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getRPAlumnosReprobados;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::getRPAlumnosReprobados',  '_route' => 'getRPAlumnosReprobados',);
                    }
                    not_getRPAlumnosReprobados:

                    // getRPFilter
                    if ($pathinfo === '/api/Controlescolar/Recuperacionperiodo/filter') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getRPFilter;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::getRPFilter',  '_route' => 'getRPFilter',);
                    }
                    not_getRPFilter:

                    // getRPMateriasReprobadasByAlumno
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Recuperacionperiodo/materiasreprobadas') && preg_match('#^/api/Controlescolar/Recuperacionperiodo/materiasreprobadas/(?P<kalumnociclo>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getRPMateriasReprobadasByAlumno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getRPMateriasReprobadasByAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::getRPMateriasReprobadasByAlumno',));
                    }
                    not_getRPMateriasReprobadasByAlumno:

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Recuperacionperiodo/recuperaciones')) {
                        // getRPRecuperacionesByAlumnoMateriape
                        if (preg_match('#^/api/Controlescolar/Recuperacionperiodo/recuperaciones/(?P<kalumnociclo>[^/]++)/(?P<kppmateriape>[^/]++)/(?P<kperiodoevaluacion>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getRPRecuperacionesByAlumnoMateriape;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getRPRecuperacionesByAlumnoMateriape')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::getRPRecuperacionesByAlumnoMateriape',));
                        }
                        not_getRPRecuperacionesByAlumnoMateriape:

                        // putRPRecuperacionesByAlumnoMateriapePeriodo
                        if (preg_match('#^/api/Controlescolar/Recuperacionperiodo/recuperaciones/(?P<kalumnociclo>[^/]++)/(?P<kppmateriape>[^/]++)/(?P<kperiodoevaluacion>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_putRPRecuperacionesByAlumnoMateriapePeriodo;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'putRPRecuperacionesByAlumnoMateriapePeriodo')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::putRPRecuperacionesByAlumnoMateriapePeriodo',));
                        }
                        not_putRPRecuperacionesByAlumnoMateriapePeriodo:

                    }

                    // deleteRPRecuperacionesById
                    if (preg_match('#^/api/Controlescolar/Recuperacionperiodo/(?P<krecuperacionperiodo>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_deleteRPRecuperacionesById;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteRPRecuperacionesById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RecuperacionPeriodoController::deleteRPRecuperacionesById',));
                    }
                    not_deleteRPRecuperacionesById:

                }

                if (0 === strpos($pathinfo, '/api/ControlEscolar')) {
                    if (0 === strpos($pathinfo, '/api/ControlEscolar/IntencionReinscribirse')) {
                        // indexIntencionReinscribirse
                        if ($pathinfo === '/api/ControlEscolar/IntencionReinscribirse') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexIntencionReinscribirse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::indexIntencionReinscribirse',  '_route' => 'indexIntencionReinscribirse',);
                        }
                        not_indexIntencionReinscribirse:

                        // buscarIntencionReinscribirse
                        if ($pathinfo === '/api/ControlEscolar/IntencionReinscribirse') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_buscarIntencionReinscribirse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::buscarIntencionReinscribirse',  '_route' => 'buscarIntencionReinscribirse',);
                        }
                        not_buscarIntencionReinscribirse:

                        // insertarIntencionReinscribirse
                        if ($pathinfo === '/api/ControlEscolar/IntencionReinscribirse/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_insertarIntencionReinscribirse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::insertarIntencionReinscribirse',  '_route' => 'insertarIntencionReinscribirse',);
                        }
                        not_insertarIntencionReinscribirse:

                    }

                    // ReenviarNotificaciones
                    if ($pathinfo === '/api/ControlEscolar/ReenviarNotificaciones') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_ReenviarNotificaciones;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::ReenviarNotificaciones',  '_route' => 'ReenviarNotificaciones',);
                    }
                    not_ReenviarNotificaciones:

                    if (0 === strpos($pathinfo, '/api/ControlEscolar/IntencionReinscribirse')) {
                        // editarIntencionReinscribirse
                        if ($pathinfo === '/api/ControlEscolar/IntencionReinscribirse/') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_editarIntencionReinscribirse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::editarIntencionReinscribirse',  '_route' => 'editarIntencionReinscribirse',);
                        }
                        not_editarIntencionReinscribirse:

                        // copiarIntencionReinscribirse
                        if ($pathinfo === '/api/ControlEscolar/IntencionReinscribirse/Copia') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_copiarIntencionReinscribirse;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\RegistroIntencionReinscribirseController::copiarIntencionReinscribirse',  '_route' => 'copiarIntencionReinscribirse',);
                        }
                        not_copiarIntencionReinscribirse:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Controlescolar')) {
                    if (0 === strpos($pathinfo, '/api/Controlescolar/Re')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion')) {
                            // Alumnosbypadretutor
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Alumnosbypadretutor') && preg_match('#^/api/Controlescolar/Reinscripcion/Alumnosbypadretutor/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_Alumnosbypadretutor;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'Alumnosbypadretutor')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::Alumnosbypadretutor',));
                            }
                            not_Alumnosbypadretutor:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Documento')) {
                                // DescargarFormatoReinscripcion
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Documentoalumno/descargar') && preg_match('#^/api/Controlescolar/Reinscripcion/Documentoalumno/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_DescargarFormatoReinscripcion;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarFormatoReinscripcion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::DescargarFormatoReinscripcion',));
                                }
                                not_DescargarFormatoReinscripcion:

                                // DescargarDocumentoSubido
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Documentossubidos/descargar') && preg_match('#^/api/Controlescolar/Reinscripcion/Documentossubidos/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_DescargarDocumentoSubido;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarDocumentoSubido')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::DescargarDocumentoSubido',));
                                }
                                not_DescargarDocumentoSubido:

                            }

                            // Formapagobyalumno
                            if ($pathinfo === '/api/Controlescolar/Reinscripcion/AlumnoPago/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_Formapagobyalumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::Formapagobyalumno',  '_route' => 'Formapagobyalumno',);
                            }
                            not_Formapagobyalumno:

                            // deleteDocumentoAlumno
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Documentossubidos/eliminar') && preg_match('#^/api/Controlescolar/Reinscripcion/Documentossubidos/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteDocumentoAlumno;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteDocumentoAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::deleteDocumentoAlumno',));
                            }
                            not_deleteDocumentoAlumno:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/GuardarDocumento')) {
                                // GuardarDocumentosReinscripcion
                                if ($pathinfo === '/api/Controlescolar/Reinscripcion/GuardarDocumentos/') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarDocumentosReinscripcion;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::GuardarDocumentosReinscripcion',  '_route' => 'GuardarDocumentosReinscripcion',);
                                }
                                not_GuardarDocumentosReinscripcion:

                                // GuardarDocumentoReinscripcion
                                if ($pathinfo === '/api/Controlescolar/Reinscripcion/GuardarDocumentoReinscripcion/') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_GuardarDocumentoReinscripcion;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::GuardarDocumentoReinscripcion',  '_route' => 'GuardarDocumentoReinscripcion',);
                                }
                                not_GuardarDocumentoReinscripcion:

                            }

                            // buscarProfesorreinscripcion
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/profesor') && preg_match('#^/api/Controlescolar/Reinscripcion/profesor/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_buscarProfesorreinscripcion;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'buscarProfesorreinscripcion')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::buscarProfesorreinscripcion',));
                            }
                            not_buscarProfesorreinscripcion:

                            // getReinscripcionFiltros
                            if ($pathinfo === '/api/Controlescolar/Reinscripcion/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getReinscripcionFiltros;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::getReinscripcionFiltros',  '_route' => 'getReinscripcionFiltros',);
                            }
                            not_getReinscripcionFiltros:

                            // getReinscripcionLista
                            if ($pathinfo === '/api/Controlescolar/Reinscripcion/Lista') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getReinscripcionLista;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::getReinscripcionLista',  '_route' => 'getReinscripcionLista',);
                            }
                            not_getReinscripcionLista:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Reinscripcion/Detalle')) {
                                // getReinscripcionDetalle
                                if (preg_match('#^/api/Controlescolar/Reinscripcion/Detalle/(?P<kreinscripcion>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getReinscripcionDetalle;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getReinscripcionDetalle')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::getReinscripcionDetalle',));
                                }
                                not_getReinscripcionDetalle:

                                // updateReinscripcionDetalle
                                if (preg_match('#^/api/Controlescolar/Reinscripcion/Detalle/(?P<kreinscripcion>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_updateReinscripcionDetalle;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateReinscripcionDetalle')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::updateReinscripcionDetalle',));
                                }
                                not_updateReinscripcionDetalle:

                            }

                            // getReinscripcionOpciones
                            if ($pathinfo === '/api/Controlescolar/Reinscripcion/Opciones') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getReinscripcionOpciones;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::getReinscripcionOpciones',  '_route' => 'getReinscripcionOpciones',);
                            }
                            not_getReinscripcionOpciones:

                            // Estatusreinscripcion
                            if ($pathinfo === '/api/Controlescolar/Reinscripcion/Estatus/') {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_Estatusreinscripcion;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReinscripcionController::Estatusreinscripcion',  '_route' => 'Estatusreinscripcion',);
                            }
                            not_Estatusreinscripcion:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Reportedisciplina')) {
                            // indexReportedisciplina
                            if ($pathinfo === '/api/Controlescolar/Reportedisciplina') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexReportedisciplina;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::indexReportedisciplina',  '_route' => 'indexReportedisciplina',);
                            }
                            not_indexReportedisciplina:

                            // getReportesdisciplina
                            if ($pathinfo === '/api/Controlescolar/Reportedisciplina/Filtrar') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getReportesdisciplina;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::getReportesdisciplina',  '_route' => 'getReportesdisciplina',);
                            }
                            not_getReportesdisciplina:

                            // SaveReportedisciplina
                            if ($pathinfo === '/api/Controlescolar/Reportedisciplina') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_SaveReportedisciplina;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::SaveReportedisciplina',  '_route' => 'SaveReportedisciplina',);
                            }
                            not_SaveReportedisciplina:

                            // updateReporteDisciplina
                            if (preg_match('#^/api/Controlescolar/Reportedisciplina/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateReporteDisciplina;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateReporteDisciplina')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::updateReporteDisciplina',));
                            }
                            not_updateReporteDisciplina:

                            // deleteReporteDisciplina
                            if (preg_match('#^/api/Controlescolar/Reportedisciplina/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteReporteDisciplina;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteReporteDisciplina')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::deleteReporteDisciplina',));
                            }
                            not_deleteReporteDisciplina:

                            // getReporteDisciplinaJasper
                            if ($pathinfo === '/api/Controlescolar/Reportedisciplina/') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getReporteDisciplinaJasper;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\ReporteDisciplinaController::getReporteDisciplinaJasper',  '_route' => 'getReporteDisciplinaJasper',);
                            }
                            not_getReporteDisciplinaJasper:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Subgrupos')) {
                        // indexSubgrupos
                        if ($pathinfo === '/api/Controlescolar/Subgrupos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexSubgrupos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::indexSubgrupos',  '_route' => 'indexSubgrupos',);
                        }
                        not_indexSubgrupos:

                        // BuscarSubgrupos
                        if ($pathinfo === '/api/Controlescolar/Subgrupos/Filtrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_BuscarSubgrupos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::BuscarSubgrupos',  '_route' => 'BuscarSubgrupos',);
                        }
                        not_BuscarSubgrupos:

                        // GuardarSubgrupo
                        if ($pathinfo === '/api/Controlescolar/Subgrupos') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarSubgrupo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::GuardarSubgrupo',  '_route' => 'GuardarSubgrupo',);
                        }
                        not_GuardarSubgrupo:

                        // EditarSubgrupo
                        if ($pathinfo === '/api/Controlescolar/Subgrupos') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_EditarSubgrupo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::EditarSubgrupo',  '_route' => 'EditarSubgrupo',);
                        }
                        not_EditarSubgrupo:

                        // EliminarSubgrupos
                        if ($pathinfo === '/api/Controlescolar/Subgrupos/Borrar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_EliminarSubgrupos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::deleteSubgrupos',  '_route' => 'EliminarSubgrupos',);
                        }
                        not_EliminarSubgrupos:

                        // CopiarSubgruposCiclo
                        if ($pathinfo === '/api/Controlescolar/Subgrupos/CopiarCiclo') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CopiarSubgruposCiclo;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\SubgrupoController::CopiarSubgruposCiclo',  '_route' => 'CopiarSubgruposCiclo',);
                        }
                        not_CopiarSubgruposCiclo:

                    }

                    if (0 === strpos($pathinfo, '/api/Controlescolar/Taller')) {
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerbitacora')) {
                            // getTallerBitacoraFilter
                            if ($pathinfo === '/api/Controlescolar/Tallerbitacora/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTallerBitacoraFilter;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerBitacoraController::getTallerBitacoraFilter',  '_route' => 'getTallerBitacoraFilter',);
                            }
                            not_getTallerBitacoraFilter:

                            // getTallerBitacora
                            if (rtrim($pathinfo, '/') === '/api/Controlescolar/Tallerbitacora') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTallerBitacora;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'getTallerBitacora');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerBitacoraController::getTallerBitacora',  '_route' => 'getTallerBitacora',);
                            }
                            not_getTallerBitacora:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Tallercurricular')) {
                            // getTCFilter
                            if ($pathinfo === '/api/Controlescolar/Tallercurricular/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTCFilter;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::getTCFilter',  '_route' => 'getTCFilter',);
                            }
                            not_getTCFilter:

                            // getTCTalleres
                            if ($pathinfo === '/api/Controlescolar/Tallercurricular') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTCTalleres;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::getTCTalleres',  '_route' => 'getTCTalleres',);
                            }
                            not_getTCTalleres:

                            // getTCTallerById
                            if (preg_match('#^/api/Controlescolar/Tallercurricular/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTCTallerById;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getTCTallerById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::getTCTallerById',));
                            }
                            not_getTCTallerById:

                            // createTCTallerCurricularById
                            if ($pathinfo === '/api/Controlescolar/Tallercurricular') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_createTCTallerCurricularById;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::createTCTallerCurricularById',  '_route' => 'createTCTallerCurricularById',);
                            }
                            not_createTCTallerCurricularById:

                            // updateTCTallerCurricularById
                            if (preg_match('#^/api/Controlescolar/Tallercurricular/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateTCTallerCurricularById;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateTCTallerCurricularById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::updateTCTallerCurricularById',));
                            }
                            not_updateTCTallerCurricularById:

                            // deleteTCTallerCurricularById
                            if (preg_match('#^/api/Controlescolar/Tallercurricular/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteTCTallerCurricularById;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteTCTallerCurricularById')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::deleteTCTallerCurricularById',));
                            }
                            not_deleteTCTallerCurricularById:

                            // createTCTallerCurricularCopy
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Tallercurricular/copiar') && preg_match('#^/api/Controlescolar/Tallercurricular/copiar/(?P<cicloid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_createTCTallerCurricularCopy;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'createTCTallerCurricularCopy')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerCurricularController::createTCTallerCurricularCopy',));
                            }
                            not_createTCTallerCurricularCopy:

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado')) {
                            // getTEAFilter
                            if ($pathinfo === '/api/Controlescolar/Tallerextracurriculararmado/filter') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTEAFilter;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::getTEAFilter',  '_route' => 'getTEAFilter',);
                            }
                            not_getTEAFilter:

                            // getTEAPDF
                            if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado/imprimir') && preg_match('#^/api/Controlescolar/Tallerextracurriculararmado/imprimir/(?P<tallerextraid>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_getTEAPDF;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getTEAPDF')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::getTEAPDF',));
                            }
                            not_getTEAPDF:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado/asignado')) {
                                // getTEAAsignadoByTaller
                                if ($pathinfo === '/api/Controlescolar/Tallerextracurriculararmado/asignado') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getTEAAsignadoByTaller;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::getTEAAsignadoByTaller',  '_route' => 'getTEAAsignadoByTaller',);
                                }
                                not_getTEAAsignadoByTaller:

                                // updateTEAAsignadoByTaller
                                if (preg_match('#^/api/Controlescolar/Tallerextracurriculararmado/asignado/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'PUT') {
                                        $allow[] = 'PUT';
                                        goto not_updateTEAAsignadoByTaller;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateTEAAsignadoByTaller')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::updateTEAAsignadoByTaller',));
                                }
                                not_updateTEAAsignadoByTaller:

                                // deleteTEAAsignadoByAlumno
                                if (preg_match('#^/api/Controlescolar/Tallerextracurriculararmado/asignado/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if ($this->context->getMethod() != 'DELETE') {
                                        $allow[] = 'DELETE';
                                        goto not_deleteTEAAsignadoByAlumno;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteTEAAsignadoByAlumno')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::deleteTEAAsignadoByAlumno',));
                                }
                                not_deleteTEAAsignadoByAlumno:

                            }

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado/material')) {
                                // getTEAMaterialByTallerId
                                if (preg_match('#^/api/Controlescolar/Tallerextracurriculararmado/material/(?P<tallerid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getTEAMaterialByTallerId;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getTEAMaterialByTallerId')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::getTEAMaterialByTallerId',));
                                }
                                not_getTEAMaterialByTallerId:

                                // setTEAMaterialByAlumnoId
                                if ($pathinfo === '/api/Controlescolar/Tallerextracurriculararmado/material') {
                                    if ($this->context->getMethod() != 'POST') {
                                        $allow[] = 'POST';
                                        goto not_setTEAMaterialByAlumnoId;
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::setTEAMaterialByAlumnoId',  '_route' => 'setTEAMaterialByAlumnoId',);
                                }
                                not_setTEAMaterialByAlumnoId:

                                // getTEAMaterialPDF
                                if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado/material/imprimir') && preg_match('#^/api/Controlescolar/Tallerextracurriculararmado/material/imprimir/(?P<alumnociclotallerextraid>[^/]++)$#s', $pathinfo, $matches)) {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_getTEAMaterialPDF;
                                    }

                                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getTEAMaterialPDF')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::getTEAMaterialPDF',));
                                }
                                not_getTEAMaterialPDF:

                            }

                            // setTEAReglamento
                            if ($pathinfo === '/api/Controlescolar/Tallerextracurriculararmado/reglamento') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_setTEAReglamento;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::setTEAReglamento',  '_route' => 'setTEAReglamento',);
                            }
                            not_setTEAReglamento:

                            // setCredencialAlumno
                            if ($pathinfo === '/api/Controlescolar/Tallerextracurriculararmado/credencial') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_setCredencialAlumno;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::setCredencialAlumno',  '_route' => 'setCredencialAlumno',);
                            }
                            not_setCredencialAlumno:

                            if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurriculararmado/descargar')) {
                                // descargarCredencial
                                if (rtrim($pathinfo, '/') === '/api/Controlescolar/Tallerextracurriculararmado/descargarCredencial') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_descargarCredencial;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'descargarCredencial');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::descargarCredencial',  '_route' => 'descargarCredencial',);
                                }
                                not_descargarCredencial:

                                // descargarReporteMaterial
                                if (rtrim($pathinfo, '/') === '/api/Controlescolar/Tallerextracurriculararmado/descargarReporteMaterial') {
                                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                        $allow = array_merge($allow, array('GET', 'HEAD'));
                                        goto not_descargarReporteMaterial;
                                    }

                                    if (substr($pathinfo, -1) !== '/') {
                                        return $this->redirect($pathinfo.'/', 'descargarReporteMaterial');
                                    }

                                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularArmadoController::descargarReporteMaterial',  '_route' => 'descargarReporteMaterial',);
                                }
                                not_descargarReporteMaterial:

                            }

                        }

                        if (0 === strpos($pathinfo, '/api/Controlescolar/TallerExtracurricular')) {
                            // indexTallerExtracurricular
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_indexTallerExtracurricular;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::indexTallerExtracurricular',  '_route' => 'indexTallerExtracurricular',);
                            }
                            not_indexTallerExtracurricular:

                            // getTallerExtracurricular
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular/Filtrar') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getTallerExtracurricular;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::getTallerExtracurricular',  '_route' => 'getTallerExtracurricular',);
                            }
                            not_getTallerExtracurricular:

                            // saveTallerExtracurricular
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_saveTallerExtracurricular;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::saveTallerExtracurricular',  '_route' => 'saveTallerExtracurricular',);
                            }
                            not_saveTallerExtracurricular:

                            // updateTallerExtracurricular
                            if (preg_match('#^/api/Controlescolar/TallerExtracurricular/(?P<tallerextracurricularid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'PUT') {
                                    $allow[] = 'PUT';
                                    goto not_updateTallerExtracurricular;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateTallerExtracurricular')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::updateTallerExtracurricular',));
                            }
                            not_updateTallerExtracurricular:

                            // deleteTallerExtracurricular
                            if (preg_match('#^/api/Controlescolar/TallerExtracurricular/(?P<tallerextracurricularid>[^/]++)$#s', $pathinfo, $matches)) {
                                if ($this->context->getMethod() != 'DELETE') {
                                    $allow[] = 'DELETE';
                                    goto not_deleteTallerExtracurricular;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteTallerExtracurricular')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::deleteTallerExtracurricular',));
                            }
                            not_deleteTallerExtracurricular:

                            // copyTallerExtracurricular
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular/Copiar') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_copyTallerExtracurricular;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::copyTallerExtracurricular',  '_route' => 'copyTallerExtracurricular',);
                            }
                            not_copyTallerExtracurricular:

                            // getAlumnos
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular/Alumnos') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_getAlumnos;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::getAlumnos',  '_route' => 'getAlumnos',);
                            }
                            not_getAlumnos:

                            // preregistroAlumnos
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular/Preregistro') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_preregistroAlumnos;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::preregistroAlumnos',  '_route' => 'preregistroAlumnos',);
                            }
                            not_preregistroAlumnos:

                            // saveMaterialTallerExtracurricular
                            if ($pathinfo === '/api/Controlescolar/TallerExtracurricular/Material') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_saveMaterialTallerExtracurricular;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::saveMaterialTallerExtracurricular',  '_route' => 'saveMaterialTallerExtracurricular',);
                            }
                            not_saveMaterialTallerExtracurricular:

                        }

                        // getCredencialJasper
                        if (0 === strpos($pathinfo, '/api/Controlescolar/Tallerextracurricular/Descargarcredencial') && preg_match('#^/api/Controlescolar/Tallerextracurricular/Descargarcredencial/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getCredencialJasper;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCredencialJasper')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TallerExtracurricularController::getCredencialJasper',));
                        }
                        not_getCredencialJasper:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/TipoBaja')) {
                // tbajas
                if ($pathinfo === '/api/TipoBaja/tiposdebaja') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_tbajas;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TipoBajaController::tbajas',  '_route' => 'tbajas',);
                }
                not_tbajas:

                // TipoBajafiltro
                if ($pathinfo === '/api/TipoBaja/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_TipoBajafiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TipoBajaController::TipoBajafiltro',  '_route' => 'TipoBajafiltro',);
                }
                not_TipoBajafiltro:

                // deletetipobaja
                if (0 === strpos($pathinfo, '/api/TipoBaja/eliminar') && preg_match('#^/api/TipoBaja/eliminar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_deletetipobaja;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletetipobaja')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TipoBajaController::deletetipobaja',));
                }
                not_deletetipobaja:

                // guardartipobaja
                if ($pathinfo === '/api/TipoBaja/Guardar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_guardartipobaja;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TipoBajaController::guardartipobaja',  '_route' => 'guardartipobaja',);
                }
                not_guardartipobaja:

                // Editartipobaja
                if (0 === strpos($pathinfo, '/api/TipoBaja/Actualizar') && preg_match('#^/api/TipoBaja/Actualizar/(?P<tipobajaid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_Editartipobaja;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'Editartipobaja')), array (  '_controller' => 'AppBundle\\Controller\\Controlescolar\\TipoBajaController::Editartipobaja',));
                }
                not_Editartipobaja:

            }

        }

        // app_default_index
        if (rtrim($pathinfo, '/') === '') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_app_default_index;
            }

            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'app_default_index');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'app_default_index',);
        }
        not_app_default_index:

        // app_default_indexpost
        if ($pathinfo === '/') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_app_default_indexpost;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexPostAction',  '_route' => 'app_default_indexpost',);
        }
        not_app_default_indexpost:

        // app_default_indexput
        if ($pathinfo === '/') {
            if ($this->context->getMethod() != 'PUT') {
                $allow[] = 'PUT';
                goto not_app_default_indexput;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexPutAction',  '_route' => 'app_default_indexput',);
        }
        not_app_default_indexput:

        // app_default_indexdelete
        if ($pathinfo === '/') {
            if ($this->context->getMethod() != 'DELETE') {
                $allow[] = 'DELETE';
                goto not_app_default_indexdelete;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexDeleteAction',  '_route' => 'app_default_indexdelete',);
        }
        not_app_default_indexdelete:

        if (0 === strpos($pathinfo, '/api')) {
            // coneccionQa
            if (rtrim($pathinfo, '/') === '/api/connectionQa') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_coneccionQa;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'coneccionQa');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::QaAction',  '_route' => 'coneccionQa',);
            }
            not_coneccionQa:

            // BuscarFamilia
            if (rtrim($pathinfo, '/') === '/api/Familia') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_BuscarFamilia;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'BuscarFamilia');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::getFamilia',  '_route' => 'BuscarFamilia',);
            }
            not_BuscarFamilia:

            if (0 === strpos($pathinfo, '/api/Controlescolar/Fam')) {
                // indexFamilia
                if ($pathinfo === '/api/Controlescolar/Famlia') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexFamilia;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::indexFamilia',  '_route' => 'indexFamilia',);
                }
                not_indexFamilia:

                if (0 === strpos($pathinfo, '/api/Controlescolar/Familia')) {
                    // BuscarClaves
                    if ($pathinfo === '/api/Controlescolar/Familia/Filtrar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarClaves;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::getClaves',  '_route' => 'BuscarClaves',);
                    }
                    not_BuscarClaves:

                    // BuscarPadres
                    if ($pathinfo === '/api/Controlescolar/Familia/Padres') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarPadres;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::getPadres',  '_route' => 'BuscarPadres',);
                    }
                    not_BuscarPadres:

                    // BuscarAlumnoFamilia
                    if ($pathinfo === '/api/Controlescolar/Familia/Alumnofamilia') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarAlumnoFamilia;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::getAlumnoFamilia',  '_route' => 'BuscarAlumnoFamilia',);
                    }
                    not_BuscarAlumnoFamilia:

                    // EliminarFamilia
                    if (preg_match('#^/api/Controlescolar/Familia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarFamilia;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarFamilia')), array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::deleteFamilia',));
                    }
                    not_EliminarFamilia:

                    // GuardarFamilia
                    if ($pathinfo === '/api/Controlescolar/Familia') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarFamilia;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::SaveFamilia',  '_route' => 'GuardarFamilia',);
                    }
                    not_GuardarFamilia:

                    // ActualizarFamilia
                    if (preg_match('#^/api/Controlescolar/Familia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarFamilia;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarFamilia')), array (  '_controller' => 'AppBundle\\Controller\\FamiliarController::updateFamilia',));
                    }
                    not_ActualizarFamilia:

                }

            }

            if (0 === strpos($pathinfo, '/api/FondoOrfandad')) {
                // indexfondoorfandad
                if ($pathinfo === '/api/FondoOrfandad/Index') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexfondoorfandad;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::indexfondoorfandad',  '_route' => 'indexfondoorfandad',);
                }
                not_indexfondoorfandad:

                // fondoOrfandadfiltro
                if ($pathinfo === '/api/FondoOrfandad/Filtrar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fondoOrfandadfiltro;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::fondoOrfandadfiltro',  '_route' => 'fondoOrfandadfiltro',);
                }
                not_fondoOrfandadfiltro:

                // GuardarFondoOrfandad
                if ($pathinfo === '/api/FondoOrfandad/GuardarFo') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_GuardarFondoOrfandad;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::GuardarFondoOrfandad',  '_route' => 'GuardarFondoOrfandad',);
                }
                not_GuardarFondoOrfandad:

                // ActualizarFondoOrfandad
                if (0 === strpos($pathinfo, '/api/FondoOrfandad/ActualizarFo') && preg_match('#^/api/FondoOrfandad/ActualizarFo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_ActualizarFondoOrfandad;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarFondoOrfandad')), array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::ActualizarFondoOrfandad',));
                }
                not_ActualizarFondoOrfandad:

                if (0 === strpos($pathinfo, '/api/FondoOrfandad/ImportacionOrfandad')) {
                    // archivodownloadt
                    if (rtrim($pathinfo, '/') === '/api/FondoOrfandad/ImportacionOrfandad') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_archivodownloadt;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'archivodownloadt');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::downloadLayout',  '_route' => 'archivodownloadt',);
                    }
                    not_archivodownloadt:

                    // archivoimportacion
                    if ($pathinfo === '/api/FondoOrfandad/ImportacionOrfandad') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_archivoimportacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::importarLayout',  '_route' => 'archivoimportacion',);
                    }
                    not_archivoimportacion:

                }

                // cancelarfondo
                if ($pathinfo === '/api/FondoOrfandad/Cancelar') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_cancelarfondo;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\FondoOrfandad\\FondoOrfandadController::cancelarfondo',  '_route' => 'cancelarfondo',);
                }
                not_cancelarfondo:

            }

            if (0 === strpos($pathinfo, '/api/Ludoteca')) {
                if (0 === strpos($pathinfo, '/api/Ludoteca/capturaludoteca')) {
                    // indexCaptura
                    if ($pathinfo === '/api/Ludoteca/capturaludoteca') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexCaptura;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::indexCaptura',  '_route' => 'indexCaptura',);
                    }
                    not_indexCaptura:

                    // getAlumnoInfo
                    if ($pathinfo === '/api/Ludoteca/capturaludoteca/alumnoinfo') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getAlumnoInfo;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::getAlumnoInfo',  '_route' => 'getAlumnoInfo',);
                    }
                    not_getAlumnoInfo:

                    // getPersonarecoge
                    if (0 === strpos($pathinfo, '/api/Ludoteca/capturaludoteca/personarecoge') && preg_match('#^/api/Ludoteca/capturaludoteca/personarecoge/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getPersonarecoge;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getPersonarecoge')), array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::getPersonarecogeporalumno',));
                    }
                    not_getPersonarecoge:

                    // BuscarCapturas
                    if ($pathinfo === '/api/Ludoteca/capturaludoteca/Filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_BuscarCapturas;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::BuscarCapturas',  '_route' => 'BuscarCapturas',);
                    }
                    not_BuscarCapturas:

                    // SaveCaptura
                    if ($pathinfo === '/api/Ludoteca/capturaludoteca') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SaveCaptura;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::SaveCaptura',  '_route' => 'SaveCaptura',);
                    }
                    not_SaveCaptura:

                    // SaveReserva
                    if ($pathinfo === '/api/Ludoteca/capturaludoteca/Reservar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_SaveReserva;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::SaveReserva',  '_route' => 'SaveReserva',);
                    }
                    not_SaveReserva:

                    if (0 === strpos($pathinfo, '/api/Ludoteca/capturaludoteca/Ca')) {
                        // CambioFecha
                        if ($pathinfo === '/api/Ludoteca/capturaludoteca/CambioFecha') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CambioFecha;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::CambioFecha',  '_route' => 'CambioFecha',);
                        }
                        not_CambioFecha:

                        // CancelarCapturaLudoteca
                        if ($pathinfo === '/api/Ludoteca/capturaludoteca/Cancelar') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_CancelarCapturaLudoteca;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\CapturaLudotecaController::CancelarCapturaLudoteca',  '_route' => 'CancelarCapturaLudoteca',);
                        }
                        not_CancelarCapturaLudoteca:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Ludoteca/Configuracion')) {
                    // getLudotecaConfiguracion
                    if ($pathinfo === '/api/Ludoteca/Configuracion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getLudotecaConfiguracion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaConfiguracionController::getLudotecaConfiguracion',  '_route' => 'getLudotecaConfiguracion',);
                    }
                    not_getLudotecaConfiguracion:

                    // updateLudotecaConfiguracion
                    if ($pathinfo === '/api/Ludoteca/Configuracion') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateLudotecaConfiguracion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaConfiguracionController::updateLudotecaConfiguracion',  '_route' => 'updateLudotecaConfiguracion',);
                    }
                    not_updateLudotecaConfiguracion:

                }

                // indexLudotecaInscripcion
                if ($pathinfo === '/api/Ludoteca/Inscripcion') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexLudotecaInscripcion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaController::indexLudotecaInscripcion',  '_route' => 'indexLudotecaInscripcion',);
                }
                not_indexLudotecaInscripcion:

                // getLudotecaMeses
                if ($pathinfo === '/api/Ludoteca/Meses') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_getLudotecaMeses;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaController::getLudotecaMeses',  '_route' => 'getLudotecaMeses',);
                }
                not_getLudotecaMeses:

                if (0 === strpos($pathinfo, '/api/Ludoteca/Inscripcion')) {
                    // getLudotecaInscripcion
                    if ($pathinfo === '/api/Ludoteca/Inscripcion/Filtrar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_getLudotecaInscripcion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaController::getLudotecaInscripcion',  '_route' => 'getLudotecaInscripcion',);
                    }
                    not_getLudotecaInscripcion:

                    // saveLudotecaInscripcion
                    if ($pathinfo === '/api/Ludoteca/Inscripcion') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveLudotecaInscripcion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaController::saveLudotecaInscripcion',  '_route' => 'saveLudotecaInscripcion',);
                    }
                    not_saveLudotecaInscripcion:

                    // updateLudotecaInscripcion
                    if (preg_match('#^/api/Ludoteca/Inscripcion/(?P<contratoid>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_updateLudotecaInscripcion;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateLudotecaInscripcion')), array (  '_controller' => 'AppBundle\\Controller\\Ludoteca\\LudotecaController::updateLudotecaInscripcion',));
                    }
                    not_updateLudotecaInscripcion:

                }

            }

            if (0 === strpos($pathinfo, '/api/Maternal')) {
                if (0 === strpos($pathinfo, '/api/Maternal/Actividad')) {
                    // BuscarActividad
                    if (rtrim($pathinfo, '/') === '/api/Maternal/Actividad') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarActividad;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarActividad');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\ActividadController::getActividad',  '_route' => 'BuscarActividad',);
                    }
                    not_BuscarActividad:

                    // GuardarActividad
                    if ($pathinfo === '/api/Maternal/Actividad') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarActividad;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\ActividadController::SaveActividad',  '_route' => 'GuardarActividad',);
                    }
                    not_GuardarActividad:

                    // ActualizarActividad
                    if (preg_match('#^/api/Maternal/Actividad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarActividad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarActividad')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\ActividadController::updateActividad',));
                    }
                    not_ActualizarActividad:

                    // EliminarActividad
                    if (preg_match('#^/api/Maternal/Actividad/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarActividad;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarActividad')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\ActividadController::deleteActividad',));
                    }
                    not_EliminarActividad:

                }

                if (0 === strpos($pathinfo, '/api/Maternal/Higiene')) {
                    // BuscarHigiene
                    if (rtrim($pathinfo, '/') === '/api/Maternal/Higiene') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarHigiene;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarHigiene');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\HigieneController::getHigiene',  '_route' => 'BuscarHigiene',);
                    }
                    not_BuscarHigiene:

                    // GuardarHigiene
                    if ($pathinfo === '/api/Maternal/Higiene') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarHigiene;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\HigieneController::SaveHigiene',  '_route' => 'GuardarHigiene',);
                    }
                    not_GuardarHigiene:

                    // ActualizarHigiene
                    if (preg_match('#^/api/Maternal/Higiene/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarHigiene;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarHigiene')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\HigieneController::updateHigiene',));
                    }
                    not_ActualizarHigiene:

                    // EliminarHigiene
                    if (preg_match('#^/api/Maternal/Higiene/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarHigiene;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarHigiene')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\HigieneController::deleteHigiene',));
                    }
                    not_EliminarHigiene:

                }

                if (0 === strpos($pathinfo, '/api/Maternal/In')) {
                    if (0 === strpos($pathinfo, '/api/Maternal/Informe')) {
                        // ImprimirInforme
                        if ($pathinfo === '/api/Maternal/Informe/Imprimir') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_ImprimirInforme;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::ImprimirInforme',  '_route' => 'ImprimirInforme',);
                        }
                        not_ImprimirInforme:

                        // indexInforme
                        if ($pathinfo === '/api/Maternal/Informe') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexInforme;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::indexInforme',  '_route' => 'indexInforme',);
                        }
                        not_indexInforme:

                        // indexConsultaInforme
                        if ($pathinfo === '/api/Maternal/Informe/Consulta') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_indexConsultaInforme;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::indexConsultaInforme',  '_route' => 'indexConsultaInforme',);
                        }
                        not_indexConsultaInforme:

                        // BuscarInforme
                        if (rtrim($pathinfo, '/') === '/api/Maternal/Informe') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarInforme;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarInforme');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::getInforme',  '_route' => 'BuscarInforme',);
                        }
                        not_BuscarInforme:

                        // GuardarInforme
                        if ($pathinfo === '/api/Maternal/Informe') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarInforme;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::SaveInforme',  '_route' => 'GuardarInforme',);
                        }
                        not_GuardarInforme:

                        // ActualizarInforme
                        if (preg_match('#^/api/Maternal/Informe/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarInforme;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarInforme')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::updateInforme',));
                        }
                        not_ActualizarInforme:

                        // EliminarInforme
                        if (preg_match('#^/api/Maternal/Informe/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarInforme;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarInforme')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InformeController::deleteInforme',));
                        }
                        not_EliminarInforme:

                    }

                    if (0 === strpos($pathinfo, '/api/Maternal/Inventario')) {
                        // BuscarInventario
                        if (rtrim($pathinfo, '/') === '/api/Maternal/Inventario') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarInventario;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'BuscarInventario');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InventarioController::getInventario',  '_route' => 'BuscarInventario',);
                        }
                        not_BuscarInventario:

                        // GuardarInventario
                        if ($pathinfo === '/api/Maternal/Inventario') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarInventario;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InventarioController::SaveInventario',  '_route' => 'GuardarInventario',);
                        }
                        not_GuardarInventario:

                        // ActualizarInventario
                        if (preg_match('#^/api/Maternal/Inventario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarInventario;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarInventario')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InventarioController::updateInventario',));
                        }
                        not_ActualizarInventario:

                        // EliminarInventario
                        if (preg_match('#^/api/Maternal/Inventario/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarInventario;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarInventario')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\InventarioController::deleteInventario',));
                        }
                        not_EliminarInventario:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Maternal/Menu')) {
                    // indexMenu
                    if ($pathinfo === '/api/Maternal/Menu') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexMenu;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::indexMenu',  '_route' => 'indexMenu',);
                    }
                    not_indexMenu:

                    // BuscarMenu
                    if (rtrim($pathinfo, '/') === '/api/Maternal/Menu') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarMenu;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarMenu');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::getMenu',  '_route' => 'BuscarMenu',);
                    }
                    not_BuscarMenu:

                    if (0 === strpos($pathinfo, '/api/Maternal/Menu/A')) {
                        if (0 === strpos($pathinfo, '/api/Maternal/Menu/Asignacion')) {
                            // ListaMenusActivos
                            if ($pathinfo === '/api/Maternal/Menu/Asignacion') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_ListaMenusActivos;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::getMenusActivos',  '_route' => 'ListaMenusActivos',);
                            }
                            not_ListaMenusActivos:

                            // BuscarAsignaciones
                            if (rtrim($pathinfo, '/') === '/api/Maternal/Menu/Asignacion') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_BuscarAsignaciones;
                                }

                                if (substr($pathinfo, -1) !== '/') {
                                    return $this->redirect($pathinfo.'/', 'BuscarAsignaciones');
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::getAsignaciones',  '_route' => 'BuscarAsignaciones',);
                            }
                            not_BuscarAsignaciones:

                        }

                        if (0 === strpos($pathinfo, '/api/Maternal/Menu/Automatico')) {
                            // AsignacionMenu
                            if ($pathinfo === '/api/Maternal/Menu/Automatico') {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_AsignacionMenu;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::getAsignacion',  '_route' => 'AsignacionMenu',);
                            }
                            not_AsignacionMenu:

                            // GuardaAsignacionAutomatica
                            if ($pathinfo === '/api/Maternal/Menu/Automatico') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_GuardaAsignacionAutomatica;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::SaveAutomatico',  '_route' => 'GuardaAsignacionAutomatica',);
                            }
                            not_GuardaAsignacionAutomatica:

                        }

                    }

                    if (0 === strpos($pathinfo, '/api/Maternal/Menu/Manual')) {
                        // GuardarAsignacion
                        if ($pathinfo === '/api/Maternal/Menu/Manual') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarAsignacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::SaveAsignacion',  '_route' => 'GuardarAsignacion',);
                        }
                        not_GuardarAsignacion:

                        // ActualizarAsignacion
                        if (preg_match('#^/api/Maternal/Menu/Manual/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarAsignacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarAsignacion')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::UpdateAsignacion',));
                        }
                        not_ActualizarAsignacion:

                        // EliminarAsignacionMenu
                        if (preg_match('#^/api/Maternal/Menu/Manual/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_EliminarAsignacionMenu;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarAsignacionMenu')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::deleteAsignacionMenu',));
                        }
                        not_EliminarAsignacionMenu:

                    }

                    // GuardarMenu
                    if ($pathinfo === '/api/Maternal/Menu') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarMenu;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::SaveMenu',  '_route' => 'GuardarMenu',);
                    }
                    not_GuardarMenu:

                    // ActualizarMenu
                    if (preg_match('#^/api/Maternal/Menu/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarMenu;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarMenu')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::updateMenu',));
                    }
                    not_ActualizarMenu:

                    // EliminarMenu
                    if (preg_match('#^/api/Maternal/Menu/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarMenu;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarMenu')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\MenuController::deleteMenu',));
                    }
                    not_EliminarMenu:

                }

                if (0 === strpos($pathinfo, '/api/Maternal/Platillo')) {
                    // BuscarPlatillo
                    if (rtrim($pathinfo, '/') === '/api/Maternal/Platillo') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarPlatillo;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarPlatillo');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\PlatilloController::getPlatillo',  '_route' => 'BuscarPlatillo',);
                    }
                    not_BuscarPlatillo:

                    // GuardarPlatillo
                    if ($pathinfo === '/api/Maternal/Platillo') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarPlatillo;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Maternal\\PlatilloController::SavePlatillo',  '_route' => 'GuardarPlatillo',);
                    }
                    not_GuardarPlatillo:

                    // ActualizarPlatillo
                    if (preg_match('#^/api/Maternal/Platillo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarPlatillo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarPlatillo')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\PlatilloController::updatePlatillo',));
                    }
                    not_ActualizarPlatillo:

                    // EliminarPlatillo
                    if (preg_match('#^/api/Maternal/Platillo/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarPlatillo;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPlatillo')), array (  '_controller' => 'AppBundle\\Controller\\Maternal\\PlatilloController::deletePlatillo',));
                    }
                    not_EliminarPlatillo:

                }

            }

            if (0 === strpos($pathinfo, '/api/p')) {
                if (0 === strpos($pathinfo, '/api/portalfamiliar/Pago')) {
                    // PPSolicitudCobro
                    if ($pathinfo === '/api/portalfamiliar/Pago/SolicitudCobro') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_PPSolicitudCobro;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagoLineaSantanderController::SolicitudCobro',  '_route' => 'PPSolicitudCobro',);
                    }
                    not_PPSolicitudCobro:

                    // PPGenerarRespuestaBanco
                    if ($pathinfo === '/api/portalfamiliar/Pago/GenerarRespuestaPagoBanco') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_PPGenerarRespuestaBanco;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagoLineaSantanderController::GenerarRespuestaBanco',  '_route' => 'PPGenerarRespuestaBanco',);
                    }
                    not_PPGenerarRespuestaBanco:

                    // PPPago
                    if ($pathinfo === '/api/portalfamiliar/Pago') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_PPPago;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagoLineaSantanderController::Pago',  '_route' => 'PPPago',);
                    }
                    not_PPPago:

                }

                // PPPagoProsa
                if ($pathinfo === '/api/prosa/Pago') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_PPPagoProsa;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagoLineaSantanderController::PagoProsa',  '_route' => 'PPPagoProsa',);
                }
                not_PPPagoProsa:

                if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea')) {
                    // PPgetDocumentosPagadosByPadreOTutorId
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/pagados/bypadreotutor') && preg_match('#^/api/portalfamiliar/pagoenlinea/pagados/bypadreotutor/(?P<empresaid>[^/]++)/(?P<padretutorid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPgetDocumentosPagadosByPadreOTutorId;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetDocumentosPagadosByPadreOTutorId')), array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagosController::getDocumentosPagadosByPadreOTutorId',));
                    }
                    not_PPgetDocumentosPagadosByPadreOTutorId:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/by')) {
                        // PPgetAlumnosDocumentosPorPagarByPadreOTutorId
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/bypadreotutor') && preg_match('#^/api/portalfamiliar/pagoenlinea/bypadreotutor/(?P<IsInsCol>[^/]++)/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPgetAlumnosDocumentosPorPagarByPadreOTutorId;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetAlumnosDocumentosPorPagarByPadreOTutorId')), array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagosController::getAlumnosDocumentosPorPagarByPadreOTutorId',));
                        }
                        not_PPgetAlumnosDocumentosPorPagarByPadreOTutorId:

                        // PPgetAlumnosDocumentosPorPagarByAlumnoId
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/byalumno') && preg_match('#^/api/portalfamiliar/pagoenlinea/byalumno/(?P<IsInsCol>[^/]++)/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPgetAlumnosDocumentosPorPagarByAlumnoId;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetAlumnosDocumentosPorPagarByAlumnoId')), array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagosController::getAlumnosDocumentosPorPagarByAlumnoId',));
                        }
                        not_PPgetAlumnosDocumentosPorPagarByAlumnoId:

                    }

                    // PPGetConvenioPagoLinea
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/convenio') && preg_match('#^/api/portalfamiliar/pagoenlinea/convenio/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetConvenioPagoLinea;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetConvenioPagoLinea')), array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagosController::PPGetConvenioPagoLinea',));
                    }
                    not_PPGetConvenioPagoLinea:

                    // PPgetDocumentosPagadosByAlumnoId
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/pagoenlinea/pagados/byalumno') && preg_match('#^/api/portalfamiliar/pagoenlinea/pagados/byalumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPgetDocumentosPagadosByAlumnoId;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetDocumentosPagadosByAlumnoId')), array (  '_controller' => 'AppBundle\\Controller\\Pagos\\PagosController::getDocumentosPagadosByAlumnoId',));
                    }
                    not_PPgetDocumentosPagadosByAlumnoId:

                }

            }

            // inicioParametros
            if ($pathinfo === '/api/Parametros') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_inicioParametros;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::indexParametro',  '_route' => 'inicioParametros',);
            }
            not_inicioParametros:

            // VersionSistemas
            if (0 === strpos($pathinfo, '/api/VersionSistema') && preg_match('#^/api/VersionSistema/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'PUT') {
                    $allow[] = 'PUT';
                    goto not_VersionSistemas;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'VersionSistemas')), array (  '_controller' => 'AppBundle\\Controller\\ParametroController::VersionSistemas',));
            }
            not_VersionSistemas:

            if (0 === strpos($pathinfo, '/api/Parametros')) {
                // inicioExpresionregular
                if (preg_match('#^/api/Parametros/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_inicioExpresionregular;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'inicioExpresionregular')), array (  '_controller' => 'AppBundle\\Controller\\ParametroController::indexRegExr',));
                }
                not_inicioExpresionregular:

                // inicioParametrosAppMovil
                if (rtrim($pathinfo, '/') === '/api/Parametros/Appmovil') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_inicioParametrosAppMovil;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'inicioParametrosAppMovil');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::indexappMovil',  '_route' => 'inicioParametrosAppMovil',);
                }
                not_inicioParametrosAppMovil:

            }

            // SolicitudTokens
            if (0 === strpos($pathinfo, '/api/Solicitud/tokens') && preg_match('#^/api/Solicitud/tokens/(?P<solicitudId>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_SolicitudTokens;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'SolicitudTokens')), array (  '_controller' => 'AppBundle\\Controller\\ParametroController::SolicitudTokens',));
            }
            not_SolicitudTokens:

            // SolicitudTokensVista
            if ($pathinfo === '/api/impresiondocumento/token') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_SolicitudTokensVista;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::SolicitudTokensVista',  '_route' => 'SolicitudTokensVista',);
            }
            not_SolicitudTokensVista:

            // getMenuBySistema
            if (0 === strpos($pathinfo, '/api/Parametros/Menu') && preg_match('#^/api/Parametros/Menu/(?P<sistemaid>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_getMenuBySistema;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getMenuBySistema')), array (  '_controller' => 'AppBundle\\Controller\\ParametroController::getMenuBySistema',));
            }
            not_getMenuBySistema:

            if (0 === strpos($pathinfo, '/api/n')) {
                // NotificacionUsuario
                if ($pathinfo === '/api/nnotificacion/usuario') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_NotificacionUsuario;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::NotificacionUsuario',  '_route' => 'NotificacionUsuario',);
                }
                not_NotificacionUsuario:

                // NotificacionEnvio
                if ($pathinfo === '/api/notificacion/envio') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_NotificacionEnvio;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::NotificacionEnvio',  '_route' => 'NotificacionEnvio',);
                }
                not_NotificacionEnvio:

            }

            // MenuERP
            if ($pathinfo === '/api/menuerp') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_MenuERP;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\ParametroController::MenuERP',  '_route' => 'MenuERP',);
            }
            not_MenuERP:

            if (0 === strpos($pathinfo, '/api/portal')) {
                if (0 === strpos($pathinfo, '/api/portalalumno')) {
                    // BuscarAlumno
                    if (0 === strpos($pathinfo, '/api/portalalumno/alumno') && preg_match('#^/api/portalalumno/alumno/(?P<alumnoid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarAlumno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAlumno')), array (  '_controller' => 'AppBundle\\Controller\\PortalAlumnoController::BuscarAlumno',));
                    }
                    not_BuscarAlumno:

                    // BuscarTipoEvento
                    if ($pathinfo === '/api/portalalumno/tipoevento') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarTipoEvento;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalAlumnoController::getTipoEvento',  '_route' => 'BuscarTipoEvento',);
                    }
                    not_BuscarTipoEvento:

                    // BuscarCalificacionesAlumno
                    if ($pathinfo === '/api/portalalumno/calificaciones') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarCalificacionesAlumno;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalAlumnoController::getCalificacionesAlumno',  '_route' => 'BuscarCalificacionesAlumno',);
                    }
                    not_BuscarCalificacionesAlumno:

                }

                if (0 === strpos($pathinfo, '/api/portalfamiliar')) {
                    // Registro
                    if ($pathinfo === '/api/portalfamiliar/registro') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_Registro;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::Registro',  '_route' => 'Registro',);
                    }
                    not_Registro:

                    // ActualizarMenuVisto
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/daily-menu') && preg_match('#^/api/portalfamiliar/daily\\-menu/(?P<menuId>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarMenuVisto;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarMenuVisto')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateMenuVisto',));
                    }
                    not_ActualizarMenuVisto:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/report')) {
                        // ActualizarInformeVisto
                        if (preg_match('#^/api/portalfamiliar/report/(?P<reportId>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarInformeVisto;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarInformeVisto')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateInformeVisto',));
                        }
                        not_ActualizarInformeVisto:

                        // ActualizarHygieneHecho
                        if (preg_match('#^/api/portalfamiliar/report/(?P<reportId>[^/]++)/hygiene/(?P<hygieneId>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarHygieneHecho;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarHygieneHecho')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateHigieneHecho',));
                        }
                        not_ActualizarHygieneHecho:

                        // ActualizarInventarioHecho
                        if (preg_match('#^/api/portalfamiliar/report/(?P<reportId>[^/]++)/stock/(?P<stockId>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_ActualizarInventarioHecho;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarInventarioHecho')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateInventarioHecho',));
                        }
                        not_ActualizarInventarioHecho:

                    }

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/parents')) {
                        // BuscarInventarioPadre
                        if (preg_match('#^/api/portalfamiliar/parents/(?P<parentId>[^/]++)/stock$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarInventarioPadre;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarInventarioPadre')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getInventarioPadre',));
                        }
                        not_BuscarInventarioPadre:

                        // BuscarInformePadre
                        if (preg_match('#^/api/portalfamiliar/parents/(?P<parentId>[^/]++)/report$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarInformePadre;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarInformePadre')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getInformePadre',));
                        }
                        not_BuscarInformePadre:

                        // BuscarAsignacionMenuPadre
                        if (preg_match('#^/api/portalfamiliar/parents/(?P<parentId>[^/]++)/daily\\-menu$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarAsignacionMenuPadre;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'BuscarAsignacionMenuPadre')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getAsignacionMenuPadre',));
                        }
                        not_BuscarAsignacionMenuPadre:

                    }

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/login')) {
                        // generarFotografiaLoginPortalFamiliar
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/login/fotografia') && preg_match('#^/api/portalfamiliar/login/fotografia/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_generarFotografiaLoginPortalFamiliar;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'generarFotografiaLoginPortalFamiliar')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::generarFotografiaLoginPortalFamiliar',));
                        }
                        not_generarFotografiaLoginPortalFamiliar:

                        // loginportalfamiliar
                        if ($pathinfo === '/api/portalfamiliar/login') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_loginportalfamiliar;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::loginPortalFamiliarAction',  '_route' => 'loginportalfamiliar',);
                        }
                        not_loginportalfamiliar:

                    }

                    // PPGetDatosUsuario
                    if ($pathinfo === '/api/portalfamiliar/DatosUsuario') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetDatosUsuario;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetDatosUsuario',  '_route' => 'PPGetDatosUsuario',);
                    }
                    not_PPGetDatosUsuario:

                    // PPCambiarPassword
                    if ($pathinfo === '/api/portalfamiliar/CambiarPassword') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_PPCambiarPassword;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::CambiarPassword',  '_route' => 'PPCambiarPassword',);
                    }
                    not_PPCambiarPassword:

                    // PPRecuperarPassword
                    if ($pathinfo === '/api/portalfamiliar/RecuperarPassword') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_PPRecuperarPassword;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::RecuperarPassword',  '_route' => 'PPRecuperarPassword',);
                    }
                    not_PPRecuperarPassword:

                    // PPPeriodoActualizacion
                    if ($pathinfo === '/api/portalfamiliar/PeriodoActualizacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPPeriodoActualizacion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetPeriodoActualizacionVigente',  '_route' => 'PPPeriodoActualizacion',);
                    }
                    not_PPPeriodoActualizacion:

                    // PPAlumnoPorPadreTutor
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/AlumnoPorPadreTutor') && preg_match('#^/api/portalfamiliar/AlumnoPorPadreTutor/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPAlumnoPorPadreTutor;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPAlumnoPorPadreTutor')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetAlumnoPorPadreTutor',));
                    }
                    not_PPAlumnoPorPadreTutor:

                    // PPGetDatosAlumno
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/DatosAlumno') && preg_match('#^/api/portalfamiliar/DatosAlumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetDatosAlumno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPGetDatosAlumno')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetDatosAlumno',));
                    }
                    not_PPGetDatosAlumno:

                    // PPEditarPadresOTutores
                    if (preg_match('#^/api/portalfamiliar/(?P<sistema>[^/]++)/PadresOTutoresAlumno$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_PPEditarPadresOTutores;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPEditarPadresOTutores')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::EditarPadresOTutores',));
                    }
                    not_PPEditarPadresOTutores:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/PersonaAutorizadaRecoger')) {
                        // PPEditarPersonaAutorizadaRecoger
                        if ($pathinfo === '/api/portalfamiliar/PersonaAutorizadaRecoger') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_PPEditarPersonaAutorizadaRecoger;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::EditarPersonaAutorizadaRecoger',  '_route' => 'PPEditarPersonaAutorizadaRecoger',);
                        }
                        not_PPEditarPersonaAutorizadaRecoger:

                        // PPAgregarPersonaAutorizadaRecoger
                        if ($pathinfo === '/api/portalfamiliar/PersonaAutorizadaRecoger') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_PPAgregarPersonaAutorizadaRecoger;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::AgregarPersonaAutorizadaRecoger',  '_route' => 'PPAgregarPersonaAutorizadaRecoger',);
                        }
                        not_PPAgregarPersonaAutorizadaRecoger:

                        // PPBorrarPersonaAutorizadaRecoger
                        if (preg_match('#^/api/portalfamiliar/PersonaAutorizadaRecoger/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_PPBorrarPersonaAutorizadaRecoger;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPBorrarPersonaAutorizadaRecoger')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::BorrarPersonaAutorizadaRecoger',));
                        }
                        not_PPBorrarPersonaAutorizadaRecoger:

                    }

                    // PPGetViveCon
                    if ($pathinfo === '/api/portalfamiliar/vivecon') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetViveCon;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetViveCon',  '_route' => 'PPGetViveCon',);
                    }
                    not_PPGetViveCon:

                    // PPGetParentesco
                    if ($pathinfo === '/api/portalfamiliar/parentesco') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetParentesco;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetParentesco',  '_route' => 'PPGetParentesco',);
                    }
                    not_PPGetParentesco:

                    // PPGetTutor
                    if ($pathinfo === '/api/portalfamiliar/tutor') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPGetTutor;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetTutor',  '_route' => 'PPGetTutor',);
                    }
                    not_PPGetTutor:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/Hermano')) {
                        // PPEditarHermanoAlumno
                        if ($pathinfo === '/api/portalfamiliar/Hermano') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_PPEditarHermanoAlumno;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::EditarHermanoAlumno',  '_route' => 'PPEditarHermanoAlumno',);
                        }
                        not_PPEditarHermanoAlumno:

                        // PPAgregarHermanoAlumno
                        if ($pathinfo === '/api/portalfamiliar/Hermano') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_PPAgregarHermanoAlumno;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::PPAgregarHermanoAlumno',  '_route' => 'PPAgregarHermanoAlumno',);
                        }
                        not_PPAgregarHermanoAlumno:

                        // PPBorrarHermanoAlumno
                        if (preg_match('#^/api/portalfamiliar/Hermano/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_PPBorrarHermanoAlumno;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPBorrarHermanoAlumno')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::BorrarHermanoAlumno',));
                        }
                        not_PPBorrarHermanoAlumno:

                    }

                    // PPDatosFacturas
                    if ($pathinfo === '/api/portalfamiliar/facturacion/datos') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPDatosFacturas;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetDatosFacturas',  '_route' => 'PPDatosFacturas',);
                    }
                    not_PPDatosFacturas:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/datosfacturacion')) {
                        // PPgetDatosFacturacion
                        if (preg_match('#^/api/portalfamiliar/datosfacturacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPgetDatosFacturacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetDatosFacturacion')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getDatosFacturacion',));
                        }
                        not_PPgetDatosFacturacion:

                        // PPupdateDatoFacturacion
                        if ($pathinfo === '/api/portalfamiliar/datosfacturacion') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_PPupdateDatoFacturacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateDatoFacturacion',  '_route' => 'PPupdateDatoFacturacion',);
                        }
                        not_PPupdateDatoFacturacion:

                        // PPdeleteDatoFacturacion
                        if (preg_match('#^/api/portalfamiliar/datosfacturacion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_PPdeleteDatoFacturacion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPdeleteDatoFacturacion')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::deleteDatoFacturacion',));
                        }
                        not_PPdeleteDatoFacturacion:

                        // PPaddDatoFacturacion
                        if ($pathinfo === '/api/portalfamiliar/datosfacturacion') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_PPaddDatoFacturacion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::addDatoFacturacion',  '_route' => 'PPaddDatoFacturacion',);
                        }
                        not_PPaddDatoFacturacion:

                        // PPupdateRFCAutomatico
                        if ($pathinfo === '/api/portalfamiliar/datosfacturacion/RFC/Automatico') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_PPupdateRFCAutomatico;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::updateRFCAutomatico',  '_route' => 'PPupdateRFCAutomatico',);
                        }
                        not_PPupdateRFCAutomatico:

                    }

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/factura')) {
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/facturacion')) {
                            // PPgetDocumentosParaFacturacionByPadreOTutorId
                            if (preg_match('#^/api/portalfamiliar/facturacion/(?P<id>[^/]++)/(?P<empresaid>[^/]++)$#s', $pathinfo, $matches)) {
                                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                    $allow = array_merge($allow, array('GET', 'HEAD'));
                                    goto not_PPgetDocumentosParaFacturacionByPadreOTutorId;
                                }

                                return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetDocumentosParaFacturacionByPadreOTutorId')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getDocumentosParaFacturacionByPadreOTutorId',));
                            }
                            not_PPgetDocumentosParaFacturacionByPadreOTutorId:

                            // PPpostaddRelDatoFacturacionDocumento
                            if ($pathinfo === '/api/portalfamiliar/facturacion') {
                                if ($this->context->getMethod() != 'POST') {
                                    $allow[] = 'POST';
                                    goto not_PPpostaddRelDatoFacturacionDocumento;
                                }

                                return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::addRelDatoFacturacionDocumento',  '_route' => 'PPpostaddRelDatoFacturacionDocumento',);
                            }
                            not_PPpostaddRelDatoFacturacionDocumento:

                        }

                        // PPReenviarFatura
                        if ($pathinfo === '/api/portalfamiliar/factura/reenviar') {
                            if ($this->context->getMethod() != 'PUT') {
                                $allow[] = 'PUT';
                                goto not_PPReenviarFatura;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::PPReenviarFatura',  '_route' => 'PPReenviarFatura',);
                        }
                        not_PPReenviarFatura:

                    }

                    // PPgetAlumnosByPadreOTutorId
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/infoalumno') && preg_match('#^/api/portalfamiliar/infoalumno/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_PPgetAlumnosByPadreOTutorId;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPgetAlumnosByPadreOTutorId')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getAlumnosByPadreOTutorId',));
                    }
                    not_PPgetAlumnosByPadreOTutorId:

                    // getReportedisciplinaByAlumno
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/Reportedisciplina') && preg_match('#^/api/portalfamiliar/Reportedisciplina/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getReportedisciplinaByAlumno;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getReportedisciplinaByAlumno')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getReportedisciplinaByAlumno',));
                    }
                    not_getReportedisciplinaByAlumno:

                    // GetUsoCfdi
                    if ($pathinfo === '/api/portalfamiliar/usocfdi') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_GetUsoCfdi;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::GetUsoCfdi',  '_route' => 'GetUsoCfdi',);
                    }
                    not_GetUsoCfdi:

                    // getHijos
                    if (0 === strpos($pathinfo, '/api/portalfamiliar/hijos') && preg_match('#^/api/portalfamiliar/hijos/(?P<padreotutorid>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getHijos;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getHijos')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliarController::getHijos',));
                    }
                    not_getHijos:

                    if (0 === strpos($pathinfo, '/api/portalfamiliar/becas/SolicitudBeca')) {
                        // PPBGetSolicitudBecaPagada
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/becas/SolicitudBeca/Pagado') && preg_match('#^/api/portalfamiliar/becas/SolicitudBeca/Pagado/(?P<ClaveFamiliarId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPBGetSolicitudBecaPagada;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPBGetSolicitudBecaPagada')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliar\\Becas\\BecaController::PPBGetSolicitudBecaPagada',));
                        }
                        not_PPBGetSolicitudBecaPagada:

                        // PPBFamilia
                        if (0 === strpos($pathinfo, '/api/portalfamiliar/becas/SolicitudBeca/Familia') && preg_match('#^/api/portalfamiliar/becas/SolicitudBeca/Familia/(?P<PadreOTutorId>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPBFamilia;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'PPBFamilia')), array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliar\\Becas\\BecaController::PPBGetBeca',));
                        }
                        not_PPBFamilia:

                        // PPBGetMensajesBecas
                        if ($pathinfo === '/api/portalfamiliar/becas/SolicitudBeca/Mensajes') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_PPBGetMensajesBecas;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\PortalFamiliar\\Becas\\BecaController::PPBGetMensajesBecas',  '_route' => 'PPBGetMensajesBecas',);
                        }
                        not_PPBGetMensajesBecas:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/api/Reportes')) {
                if (0 === strpos($pathinfo, '/api/Reportes/AcumuladoInasistencias')) {
                    // AcumuladoInasistencias
                    if ($pathinfo === '/api/Reportes/AcumuladoInasistencias') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_AcumuladoInasistencias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\AcumuladoInasistenciasController::AcumuladoInasistencias',  '_route' => 'AcumuladoInasistencias',);
                    }
                    not_AcumuladoInasistencias:

                    // GetInasistencias
                    if ($pathinfo === '/api/Reportes/AcumuladoInasistencias/Consultar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_GetInasistencias;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\AcumuladoInasistenciasController::GetInasistencias',  '_route' => 'GetInasistencias',);
                    }
                    not_GetInasistencias:

                    // ReporteInasistencias
                    if (0 === strpos($pathinfo, '/api/Reportes/AcumuladoInasistencias/ReporteInasistencias') && preg_match('#^/api/Reportes/AcumuladoInasistencias/ReporteInasistencias/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteInasistencias;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ReporteInasistencias')), array (  '_controller' => 'AppBundle\\Controller\\Reportes\\AcumuladoInasistenciasController::ReporteInasistencias',));
                    }
                    not_ReporteInasistencias:

                }

                // Jasper
                if ($pathinfo === '/api/Reportes/jasper') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_Jasper;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesController::jasper',  '_route' => 'Jasper',);
                }
                not_Jasper:

                if (0 === strpos($pathinfo, '/api/Reportes/Calificaciones')) {
                    // indexReporteCalificaciones
                    if ($pathinfo === '/api/Reportes/Calificaciones') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexReporteCalificaciones;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesController::indexReporteCalificaciones',  '_route' => 'indexReporteCalificaciones',);
                    }
                    not_indexReporteCalificaciones:

                    // ReporteCalificaciones
                    if (rtrim($pathinfo, '/') === '/api/Reportes/Calificaciones') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteCalificaciones;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'ReporteCalificaciones');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesController::ReporteCalificaciones',  '_route' => 'ReporteCalificaciones',);
                    }
                    not_ReporteCalificaciones:

                    // ReporteCalificacionesIndice
                    if ($pathinfo === '/api/Reportes/Calificaciones/indice') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ReporteCalificacionesIndice;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesController::ReporteCalificacionesIndice',  '_route' => 'ReporteCalificacionesIndice',);
                    }
                    not_ReporteCalificacionesIndice:

                    // CalificacionesDescargar
                    if ($pathinfo === '/api/Reportes/Calificaciones/Descargar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_CalificacionesDescargar;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesController::CalificacionesDescargar',  '_route' => 'CalificacionesDescargar',);
                    }
                    not_CalificacionesDescargar:

                    if (0 === strpos($pathinfo, '/api/Reportes/Calificacionescualitativas')) {
                        // getFiltrosCalCualitativas
                        if (rtrim($pathinfo, '/') === '/api/Reportes/Calificacionescualitativas') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_getFiltrosCalCualitativas;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'getFiltrosCalCualitativas');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesCualitativasController::FiltrosCalificacionesCualitativas',  '_route' => 'getFiltrosCalCualitativas',);
                        }
                        not_getFiltrosCalCualitativas:

                        // BuscarCalCualitativas
                        if ($pathinfo === '/api/Reportes/Calificacionescualitativas/BuscarCalCualitativas') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_BuscarCalCualitativas;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\CalificacionesCualitativasController::BuscarCalCualitativas',  '_route' => 'BuscarCalCualitativas',);
                        }
                        not_BuscarCalCualitativas:

                    }

                }

                if (0 === strpos($pathinfo, '/api/Reportes/MetasInscripcion')) {
                    // indexMetasinscripcion
                    if ($pathinfo === '/api/Reportes/MetasInscripcion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexMetasinscripcion;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\MetasInscripcionController::indexMetasinscripcion',  '_route' => 'indexMetasinscripcion',);
                    }
                    not_indexMetasinscripcion:

                    // GetMetas
                    if ($pathinfo === '/api/Reportes/MetasInscripcion/Consultar') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_GetMetas;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\MetasInscripcionController::GetMetas',  '_route' => 'GetMetas',);
                    }
                    not_GetMetas:

                    // getReporteMetasInscripcion
                    if (rtrim($pathinfo, '/') === '/api/Reportes/MetasInscripcion/ReporteMetasInscripcion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getReporteMetasInscripcion;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'getReporteMetasInscripcion');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Reportes\\MetasInscripcionController::getReporteMetasInscripcion',  '_route' => 'getReporteMetasInscripcion',);
                    }
                    not_getReporteMetasInscripcion:

                }

            }

            // FamiliarHome
            if ($pathinfo === '/api/Familiar/home') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_FamiliarHome;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::homeAction',  '_route' => 'FamiliarHome',);
            }
            not_FamiliarHome:

            // downloadt
            if (rtrim($pathinfo, '/') === '/api/Solicitud/ImportacionSolicitud') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_downloadt;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'downloadt');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::downloadLayout',  '_route' => 'downloadt',);
            }
            not_downloadt:

            if (0 === strpos($pathinfo, '/api/Familiar')) {
                if (0 === strpos($pathinfo, '/api/Familiar/expediente')) {
                    // expediente
                    if (rtrim($pathinfo, '/') === '/api/Familiar/expediente') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_expediente;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'expediente');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::expedienteAction',  '_route' => 'expediente',);
                    }
                    not_expediente:

                    if (0 === strpos($pathinfo, '/api/Familiar/expediente/grado')) {
                        // GradosRepetidos
                        if (rtrim($pathinfo, '/') === '/api/Familiar/expediente/gradosRepetidos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_GradosRepetidos;
                            }

                            if (substr($pathinfo, -1) !== '/') {
                                return $this->redirect($pathinfo.'/', 'GradosRepetidos');
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::gradosRepetidosAction',  '_route' => 'GradosRepetidos',);
                        }
                        not_GradosRepetidos:

                        // gradorepetidoSave
                        if ($pathinfo === '/api/Familiar/expediente/gradorepetido/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_gradorepetidoSave;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::saveGradoAction',  '_route' => 'gradorepetidoSave',);
                        }
                        not_gradorepetidoSave:

                        // GradosRemove1
                        if ($pathinfo === '/api/Familiar/expediente/grados/') {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_GradosRemove1;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::removeGradosAction',  '_route' => 'GradosRemove1',);
                        }
                        not_GradosRemove1:

                    }

                    // expedienteSave
                    if ($pathinfo === '/api/Familiar/expediente/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_expedienteSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::saveExpedienteAction',  '_route' => 'expedienteSave',);
                    }
                    not_expedienteSave:

                }

                // datosFamiliares
                if ($pathinfo === '/api/Familiar/datosFamiliares') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_datosFamiliares;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::datosFamiliaresAction',  '_route' => 'datosFamiliares',);
                }
                not_datosFamiliares:

            }

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                // DireccionByCp
                if ($pathinfo === '/api/Solicitud/direccion/cp') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_DireccionByCp;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::direccionByCpAction',  '_route' => 'DireccionByCp',);
                }
                not_DireccionByCp:

                if (0 === strpos($pathinfo, '/api/Solicitud/hermano')) {
                    // hermano
                    if ($pathinfo === '/api/Solicitud/hermano') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_hermano;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::hermanoAction',  '_route' => 'hermano',);
                    }
                    not_hermano:

                    // hermanoValidacion
                    if (rtrim($pathinfo, '/') === '/api/Solicitud/hermano/Validacion') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_hermanoValidacion;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'hermanoValidacion');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::hermanoValidacionAction',  '_route' => 'hermanoValidacion',);
                    }
                    not_hermanoValidacion:

                }

            }

            if (0 === strpos($pathinfo, '/api/Familiar/d')) {
                if (0 === strpos($pathinfo, '/api/Familiar/datosFamiliares')) {
                    if (0 === strpos($pathinfo, '/api/Familiar/datosFamiliares/padres')) {
                        // datosFamiliarespadres
                        if ($pathinfo === '/api/Familiar/datosFamiliares/padres') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_datosFamiliarespadres;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::datosFamiliaresPadresAction',  '_route' => 'datosFamiliarespadres',);
                        }
                        not_datosFamiliarespadres:

                        // datosFamiliarespadresNacionalidades
                        if ($pathinfo === '/api/Familiar/datosFamiliares/padres/nacionalidades') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_datosFamiliarespadresNacionalidades;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::datosFamiliaresPadresnacioNalidadesAction',  '_route' => 'datosFamiliarespadresNacionalidades',);
                        }
                        not_datosFamiliarespadresNacionalidades:

                    }

                    // datosFamiliaresHermanos
                    if ($pathinfo === '/api/Familiar/datosFamiliares/Hermanos') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_datosFamiliaresHermanos;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::datosFamiliaresHermanosAction',  '_route' => 'datosFamiliaresHermanos',);
                    }
                    not_datosFamiliaresHermanos:

                    // datosFamiliaresPadresSave
                    if ($pathinfo === '/api/Familiar/datosFamiliares/padres') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_datosFamiliaresPadresSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::savePadresAction',  '_route' => 'datosFamiliaresPadresSave',);
                    }
                    not_datosFamiliaresPadresSave:

                    if (0 === strpos($pathinfo, '/api/Familiar/datosFamiliares/Hermano')) {
                        // datosFamiliaresHermanoSave
                        if ($pathinfo === '/api/Familiar/datosFamiliares/Hermano/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_datosFamiliaresHermanoSave;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::saveHermanoAction',  '_route' => 'datosFamiliaresHermanoSave',);
                        }
                        not_datosFamiliaresHermanoSave:

                        // datosFamiliaresHermanoRemove
                        if ($pathinfo === '/api/Familiar/datosFamiliares/Hermano/') {
                            if ($this->context->getMethod() != 'DELETE') {
                                $allow[] = 'DELETE';
                                goto not_datosFamiliaresHermanoRemove;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::removeHermanoAction',  '_route' => 'datosFamiliaresHermanoRemove',);
                        }
                        not_datosFamiliaresHermanoRemove:

                    }

                    // datosFamiliaresSave
                    if ($pathinfo === '/api/Familiar/datosFamiliares/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_datosFamiliaresSave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::saveDatosFamiliaresAction',  '_route' => 'datosFamiliaresSave',);
                    }
                    not_datosFamiliaresSave:

                }

                // documentacion
                if ($pathinfo === '/api/Familiar/documentacion') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_documentacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::documentacionAction',  '_route' => 'documentacion',);
                }
                not_documentacion:

            }

            if (0 === strpos($pathinfo, '/api/ValidacionDatos')) {
                // ValidacionDatos
                if (rtrim($pathinfo, '/') === '/api/ValidacionDatos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ValidacionDatos;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'ValidacionDatos');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::ValidacionDatosAction',  '_route' => 'ValidacionDatos',);
                }
                not_ValidacionDatos:

                // ValidacionDatosNacionalidadesAspirante
                if (0 === strpos($pathinfo, '/api/ValidacionDatos/Nacionalidad') && preg_match('#^/api/ValidacionDatos/Nacionalidad/(?P<idSolicitud>[^/]++)/?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_ValidacionDatosNacionalidadesAspirante;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'ValidacionDatosNacionalidadesAspirante');
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'ValidacionDatosNacionalidadesAspirante')), array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::nacionalidadDatosAction',));
                }
                not_ValidacionDatosNacionalidadesAspirante:

                // ValidacionDatosPadresRemove
                if ($pathinfo === '/api/ValidacionDatos/datosFamiliares/padres/') {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_ValidacionDatosPadresRemove;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::removePadresActionValidacionDatos',  '_route' => 'ValidacionDatosPadresRemove',);
                }
                not_ValidacionDatosPadresRemove:

            }

            if (0 === strpos($pathinfo, '/api/Solicitud')) {
                // SolicitudDictamen
                if ($pathinfo === '/api/Solicitud/Dictamen') {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_SolicitudDictamen;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::solicitudDictamenAction',  '_route' => 'SolicitudDictamen',);
                }
                not_SolicitudDictamen:

                // SolicitudCarta
                if (rtrim($pathinfo, '/') === '/api/Solicitud/Carta') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudCarta;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'SolicitudCarta');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::solicitudCartas',  '_route' => 'SolicitudCarta',);
                }
                not_SolicitudCarta:

                // SolicitudFormatoSolicitud
                if (rtrim($pathinfo, '/') === '/api/Solicitud/FormatoSolicitud') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_SolicitudFormatoSolicitud;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'SolicitudFormatoSolicitud');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::solicitudFormatoSolicitud',  '_route' => 'SolicitudFormatoSolicitud',);
                }
                not_SolicitudFormatoSolicitud:

                // infoadicionalHermano
                if ($pathinfo === '/api/Solicitud/hermano/infoAdicional') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_infoadicionalHermano;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::hermanoNextAction',  '_route' => 'infoadicionalHermano',);
                }
                not_infoadicionalHermano:

                if (0 === strpos($pathinfo, '/api/Solicitud/personaRecogen')) {
                    // personaRecogensave
                    if ($pathinfo === '/api/Solicitud/personaRecogen/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_personaRecogensave;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::personasRecogenAction',  '_route' => 'personaRecogensave',);
                    }
                    not_personaRecogensave:

                    // DeletePersonaRecoge
                    if ($pathinfo === '/api/Solicitud/personaRecogen/') {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_DeletePersonaRecoge;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::deletePersonaRecogeAction',  '_route' => 'DeletePersonaRecoge',);
                    }
                    not_DeletePersonaRecoge:

                }

                // imprecinDocumentacion
                if ($pathinfo === '/api/Solicitud/imprecioDocumentacion/') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_imprecinDocumentacion;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::imprecionDocumentacionAction',  '_route' => 'imprecinDocumentacion',);
                }
                not_imprecinDocumentacion:

            }

            if (0 === strpos($pathinfo, '/api/Familiar')) {
                if (0 === strpos($pathinfo, '/api/Familiar/infoComplementaria')) {
                    // infoComplementaria
                    if (rtrim($pathinfo, '/') === '/api/Familiar/infoComplementaria') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_infoComplementaria;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'infoComplementaria');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::informacionComplementariaAction',  '_route' => 'infoComplementaria',);
                    }
                    not_infoComplementaria:

                    // saveInfoComplementaria
                    if ($pathinfo === '/api/Familiar/infoComplementaria/') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_saveInfoComplementaria;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::addInformacionComplementariaAction',  '_route' => 'saveInfoComplementaria',);
                    }
                    not_saveInfoComplementaria:

                }

                // saveAdmisionContratos
                if ($pathinfo === '/api/Familiar/Admision/Contratos') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_saveAdmisionContratos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::addInfoContratos',  '_route' => 'saveAdmisionContratos',);
                }
                not_saveAdmisionContratos:

            }

            // DescargarContratoAdmision
            if (0 === strpos($pathinfo, '/api/Contratos/Admision/descargar') && preg_match('#^/api/Contratos/Admision/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_DescargarContratoAdmision;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarContratoAdmision')), array (  '_controller' => 'AppBundle\\Controller\\SolicitudController::descargarContratosAdmision',));
            }
            not_DescargarContratoAdmision:

            if (0 === strpos($pathinfo, '/api/Transporte')) {
                if (0 === strpos($pathinfo, '/api/Transporte/Boleto')) {
                    // indexBoleto
                    if ($pathinfo === '/api/Transporte/Boleto') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexBoleto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::indexBoleto',  '_route' => 'indexBoleto',);
                    }
                    not_indexBoleto:

                    if (0 === strpos($pathinfo, '/api/Transporte/Boleto/Disponibilidad')) {
                        // buscarDisponibilidad
                        if ($pathinfo === '/api/Transporte/Boleto/Disponibilidad') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_buscarDisponibilidad;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::getDisponibilidad',  '_route' => 'buscarDisponibilidad',);
                        }
                        not_buscarDisponibilidad:

                        // buscarDisponibilidadAlumnos
                        if ($pathinfo === '/api/Transporte/Boleto/Disponibilidad/Alumnos') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_buscarDisponibilidadAlumnos;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::getDisponibilidadAlumnos',  '_route' => 'buscarDisponibilidadAlumnos',);
                        }
                        not_buscarDisponibilidadAlumnos:

                    }

                    // GuardarBoleto
                    if ($pathinfo === '/api/Transporte/Boleto/Vender') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarBoleto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::SaveBoleto',  '_route' => 'GuardarBoleto',);
                    }
                    not_GuardarBoleto:

                }

                // MisBoletos
                if ($pathinfo === '/api/Transporte/Misboletos') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_MisBoletos;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::getMisBoletos',  '_route' => 'MisBoletos',);
                }
                not_MisBoletos:

                if (0 === strpos($pathinfo, '/api/Transporte/Boleto')) {
                    // getBoleto
                    if (rtrim($pathinfo, '/') === '/api/Transporte/Boleto/pdf') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_getBoleto;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'getBoleto');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::getBoletos',  '_route' => 'getBoleto',);
                    }
                    not_getBoleto:

                    // EliminarBoleto
                    if ($pathinfo === '/api/Transporte/Boleto/Cancelar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_EliminarBoleto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::DeleteBoleto',  '_route' => 'EliminarBoleto',);
                    }
                    not_EliminarBoleto:

                    // DeleteBoletoFamiliar
                    if ($pathinfo === '/api/Transporte/Boleto/Familiar/Cancelar') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_DeleteBoletoFamiliar;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::DeleteBoletoFamiliar',  '_route' => 'DeleteBoletoFamiliar',);
                    }
                    not_DeleteBoletoFamiliar:

                    // ActualizaBoleto
                    if ($pathinfo === '/api/Transporte/Boleto/Actualizar') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizaBoleto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::updateBoleto',  '_route' => 'ActualizaBoleto',);
                    }
                    not_ActualizaBoleto:

                }

                // MisBoletosBitacora
                if ($pathinfo === '/api/Transporte/Misboletos/Bitacora') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_MisBoletosBitacora;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\BoletoController::getBitacoraboletos',  '_route' => 'MisBoletosBitacora',);
                }
                not_MisBoletosBitacora:

                if (0 === strpos($pathinfo, '/api/Transporte/Contrato')) {
                    // indexContrato
                    if ($pathinfo === '/api/Transporte/Contrato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexContrato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::indexContrato',  '_route' => 'indexContrato',);
                    }
                    not_indexContrato:

                    // buscarContrato
                    if (rtrim($pathinfo, '/') === '/api/Transporte/Contrato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_buscarContrato;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'buscarContrato');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::getContrato',  '_route' => 'buscarContrato',);
                    }
                    not_buscarContrato:

                    // ContratoDetalle
                    if ($pathinfo === '/api/Transporte/Contrato/detalle') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_ContratoDetalle;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::getContratodetalle',  '_route' => 'ContratoDetalle',);
                    }
                    not_ContratoDetalle:

                    // GuardarContrato
                    if ($pathinfo === '/api/Transporte/Contrato') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarContrato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::SaveContrato',  '_route' => 'GuardarContrato',);
                    }
                    not_GuardarContrato:

                    // ActualizarContrato
                    if ($pathinfo === '/api/Transporte/Contrato/Estatus/') {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarContrato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::updateContrato',  '_route' => 'ActualizarContrato',);
                    }
                    not_ActualizarContrato:

                    // DescargarCredencial
                    if ($pathinfo === '/api/Transporte/Contrato/Credencial') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_DescargarCredencial;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::downloadCredencial',  '_route' => 'DescargarCredencial',);
                    }
                    not_DescargarCredencial:

                    // MigrarContratos
                    if (0 === strpos($pathinfo, '/api/Transporte/Contrato/Migrar') && preg_match('#^/api/Transporte/Contrato/Migrar/(?P<execute>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_MigrarContratos;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'MigrarContratos')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\ContratoController::MigrarContratos',));
                    }
                    not_MigrarContratos:

                }

                // indexOffline
                if ($pathinfo === '/api/Transporte/Descargar') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_indexOffline;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\OfflineController::indexBoleto',  '_route' => 'indexOffline',);
                }
                not_indexOffline:

                if (0 === strpos($pathinfo, '/api/Transporte/Plantillacontrato')) {
                    // indexPlantillaContrato
                    if ($pathinfo === '/api/Transporte/Plantillacontrato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_indexPlantillaContrato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::indexPLantillaContrat',  '_route' => 'indexPlantillaContrato',);
                    }
                    not_indexPlantillaContrato:

                    // BuscarPlantillaContrato
                    if (rtrim($pathinfo, '/') === '/api/Transporte/Plantillacontrato') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarPlantillaContrato;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarPlantillaContrato');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::buscarPLantillaContrat',  '_route' => 'BuscarPlantillaContrato',);
                    }
                    not_BuscarPlantillaContrato:

                    // EliminarPlantillacontrato
                    if (preg_match('#^/api/Transporte/Plantillacontrato/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarPlantillacontrato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarPlantillacontrato')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::deletePlantillacontrato',));
                    }
                    not_EliminarPlantillacontrato:

                    // GuardarPlantillacontrato
                    if ($pathinfo === '/api/Transporte/Plantillacontrato') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarPlantillacontrato;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::SavePlantillacontrato',  '_route' => 'GuardarPlantillacontrato',);
                    }
                    not_GuardarPlantillacontrato:

                    // ActualizarPlantillacontrato
                    if (preg_match('#^/api/Transporte/Plantillacontrato/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_ActualizarPlantillacontrato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'ActualizarPlantillacontrato')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::UpdatePlantillacontrato',));
                    }
                    not_ActualizarPlantillacontrato:

                    // DescargarPlantillaContrato
                    if (0 === strpos($pathinfo, '/api/Transporte/Plantillacontrato/descargar') && preg_match('#^/api/Transporte/Plantillacontrato/descargar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DescargarPlantillaContrato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarPlantillaContrato')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::downloadPlantilla',));
                    }
                    not_DescargarPlantillaContrato:

                    // DescargarContrato
                    if (0 === strpos($pathinfo, '/api/Transporte/Plantillacontrato/Contrato') && preg_match('#^/api/Transporte/Plantillacontrato/Contrato/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_DescargarContrato;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'DescargarContrato')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\PlantillaContratoController::downloadContrato',));
                    }
                    not_DescargarContrato:

                }

                if (0 === strpos($pathinfo, '/api/Transporte/Ruta')) {
                    // BuscarRuta
                    if (rtrim($pathinfo, '/') === '/api/Transporte/Ruta') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_BuscarRuta;
                        }

                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'BuscarRuta');
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::indexRuta',  '_route' => 'BuscarRuta',);
                    }
                    not_BuscarRuta:

                    // RutaDetalle
                    if (0 === strpos($pathinfo, '/api/Transporte/Ruta/detalle') && preg_match('#^/api/Transporte/Ruta/detalle/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_RutaDetalle;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'RutaDetalle')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::detalleRuta',));
                    }
                    not_RutaDetalle:

                    // EliminarRuta
                    if (preg_match('#^/api/Transporte/Ruta/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_EliminarRuta;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'EliminarRuta')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::deleteRuta',));
                    }
                    not_EliminarRuta:

                    // GuardarRuta
                    if ($pathinfo === '/api/Transporte/Ruta') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_GuardarRuta;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::SaveRuta',  '_route' => 'GuardarRuta',);
                    }
                    not_GuardarRuta:

                    if (0 === strpos($pathinfo, '/api/Transporte/Ruta/Excepcion')) {
                        // RutaExcepcion
                        if (preg_match('#^/api/Transporte/Ruta/Excepcion/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_RutaExcepcion;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'RutaExcepcion')), array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::excepcionRuta',));
                        }
                        not_RutaExcepcion:

                        // GuardarRutaExcepcion
                        if ($pathinfo === '/api/Transporte/Ruta/Excepcion/') {
                            if ($this->context->getMethod() != 'POST') {
                                $allow[] = 'POST';
                                goto not_GuardarRutaExcepcion;
                            }

                            return array (  '_controller' => 'AppBundle\\Controller\\Transporte\\RutaController::SaveexcepcionRuta',  '_route' => 'GuardarRutaExcepcion',);
                        }
                        not_GuardarRutaExcepcion:

                    }

                }

            }

            // BuscarLoginExterno
            if ($pathinfo === '/api/Loginexterno') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_BuscarLoginExterno;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UsuarioController::getBuscarLoginexterno',  '_route' => 'BuscarLoginExterno',);
            }
            not_BuscarLoginExterno:

            if (0 === strpos($pathinfo, '/api/Usuario')) {
                if (0 === strpos($pathinfo, '/api/Usuario/Foto')) {
                    // UsuarioBuscarFoto
                    if (preg_match('#^/api/Usuario/Foto/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_UsuarioBuscarFoto;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'UsuarioBuscarFoto')), array (  '_controller' => 'AppBundle\\Controller\\UsuarioController::getUsuarioFoto',));
                    }
                    not_UsuarioBuscarFoto:

                    // UsuarioGuardarFoto
                    if ($pathinfo === '/api/Usuario/Foto') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_UsuarioGuardarFoto;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\UsuarioController::usuarioGuardarFoto',  '_route' => 'UsuarioGuardarFoto',);
                    }
                    not_UsuarioGuardarFoto:

                    // UsuarioRomoveFoto
                    if (preg_match('#^/api/Usuario/Foto/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_UsuarioRomoveFoto;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'UsuarioRomoveFoto')), array (  '_controller' => 'AppBundle\\Controller\\UsuarioController::usuarioEliminarFoto',));
                    }
                    not_UsuarioRomoveFoto:

                }

                // UsuarioEscaner
                if ($pathinfo === '/api/Usuario/Escaner') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_UsuarioEscaner;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UsuarioController::usuarioEscaner',  '_route' => 'UsuarioEscaner',);
                }
                not_UsuarioEscaner:

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
