<?php
/**
 * This file is part of FPDI
 *
 * @package   AppBundle\Dominio\PDFMerger\Fpdi
 * @copyright Copyright (c) 2019 Setasign - Jan Slabon (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */

namespace AppBundle\Dominio\PDFMerger\Fpdi\PdfParser\Filter;

/**
 * Exception for Ascii85 filter class
 *
 * @package AppBundle\Dominio\PDFMerger\Fpdi\PdfParser\Filter
 */
class Ascii85Exception extends FilterException
{
    /**
     * @var integer
     */
    const ILLEGAL_CHAR_FOUND = 0x0301;

    /**
     * @var integer
     */
    const ILLEGAL_LENGTH = 0x0302;
}
