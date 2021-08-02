<?php
/**
 * This file is part of FPDI
 *
 * @package   AppBundle\Dominio\PDFMerger\Fpdi
 * @copyright Copyright (c) 2019 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace AppBundle\Dominio\PDFMerger\Fpdi;

use AppBundle\Controller\lib\PDFMerger\tcpdf\FPDF as AppBundleFPDF;

/**
 * Class FpdfTpl
 *
 * This class adds a templating feature to FPDF.
 *
 * @package AppBundle\Dominio\PDFMerger\Fpdi
 */
class FpdfTpl extends AppBundleFPDF
{
    use FpdfTplTrait;
}
