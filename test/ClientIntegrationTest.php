<?php
/**
 * PDFApiTest
 * PHP version 5
 *
 * @category Class
 * @package  DocSpring
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * API V1
 *
 * No description provided (generated by Openapi Generator https://github.com/openapitools/openapi-generator)
 *
 * OpenAPI spec version: v1
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 3.3.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the endpoint.
 */

namespace DocSpring;

use \DocSpring\Configuration;
use \DocSpring\ApiException;
use \DocSpring\ObjectSerializer;

/**
 * ClientTest Class Doc Comment
 *
 * @category Class
 * @package  DocSpring
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
      $docspring = new \DocSpring\Client();
      $docspring->getConfig()
        ->setUsername("api_token123")
        ->setPassword("testsecret123");
      $this->docspring = $docspring;
      $this->docspring->getConfig()
        ->setHost('http://api.docspring.local:31337/api/v1');
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test case for generatePDF
     *
     * Generates a new PDF.
     *
     */
    public function testGeneratePDF()
    {
      $docspring = $this->docspring;
      $template_id = 'tpl_000000000000000001'; // string |
      $submission_data = new \DocSpring\Model\SubmissionData();
      $submission_data->setData([
        "first_name" => 'John',
        "last_name" => 'Smith',
        "phone_number" => '+11234567890',
      ]);
      $submission_data->setTest(false);
      $submission_data->setFieldOverrides([
        "phone_number" => [
          "required" => false
        ]
      ]);
      $submission = $docspring->generatePDF($template_id, $submission_data);

      $this->assertEquals(False, $submission->getExpired());
      $this->assertEquals('processed', $submission->getState());
      $this->assertStringStartsWith('sub_', $submission->getId());
    }

    /**
     * Test case for combineSubmissions
     *
     * Merge generated PDFs together.
     * This is actually coming from PdfAPI but I wrote the test before I
     * remembered so I'll just leave it in. Makes sure we can call
     * methods on the superclass.
     * Another thing to remember is that we expire the first submission in
     * a previous test, so it can't be used in this test.
     *
     */
    public function testCombineSubmissions()
    {
      $combined_submission_data = new Model\CombinedSubmissionData(); // \DocSpring\Model\CombinedSubmissionData |
      $combined_submission_data->setSubmissionIds(
        array('sub_000000000000000002', 'sub_000000000000000002'));
      $combined_submission = $this->docspring->combineSubmissions($combined_submission_data);
      $this->assertStringStartsWith('com_', $combined_submission->getId());
      $this->assertEquals('processed', $combined_submission->getState());
    }

    /**
     * Test case for combinePdfs
     *
     * Merge submission PDFs, template PDFs, or custom files.
     *
     */
    public function testCombinePdfs()
    {
      $combine_pdfs_data = new Model\CombinePdfsData(); // \DocSpring\Model\CombinePdfsData |
      $combine_pdfs_data->setSourcePdfs(
        array(
          ['type' => 'submission', 'id' => 'sub_000000000000000002'],
          ['type' => 'submission', 'id' => 'sub_000000000000000004']
        )
      );
      $combined_submission = $this->docspring->combinePdfs($combine_pdfs_data);
      $this->assertStringStartsWith('com_', $combined_submission->getId());
      $this->assertEquals('processed', $combined_submission->getState());
    }
}
