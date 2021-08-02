<?php
/**
 * This file is part of FPDI
 *
 * @package   AppBundle\Dominio\PDFMerger\Fpdi
 * @copyright Copyright (c) 2019 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace AppBundle\Dominio\PDFMerger\Fpdi\PdfParser\Type;

use AppBundle\Dominio\PDFMerger\Fpdi\PdfParser\PdfParserException;

/**
 * Exception class for pdf type classes
 *
 * @package AppBundle\Dominio\PDFMerger\Fpdi\PdfParser\Type
 */
class PdfTypeException extends PdfParserException
{
    /**
     * @var int
     */
    const NO_NEWLINE_AFTER_STREAM_KEYWORD = 0x0601;
}
