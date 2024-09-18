<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\POST(
 *     path="/api/consultations",
 *     summary="Ajouter une consultation",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="date", type="string"),
 *                     @OA\Property(property="terme", type="string"),
 *                     @OA\Property(property="SA", type="string"),
 *                     @OA\Property(property="plaintes", type="string"),
 *                     @OA\Property(property="mois", type="integer"),
 *                     @OA\Property(property="poids", type="integer"),
 *                     @OA\Property(property="taille", type="integer"),
 *                     @OA\Property(property="PB", type="integer"),
 *                     @OA\Property(property="temperature", type="integer"),
 *                     @OA\Property(property="urine", type="string"),
 *                     @OA\Property(property="sucre", type="string"),
 *                     @OA\Property(property="TA", type="string"),
 *                     @OA\Property(property="pouls", type="integer"),
 *                     @OA\Property(property="EG", type="string"),
 *                     @OA\Property(property="muqueuse", type="string"),
 *                     @OA\Property(property="mollet", type="string"),
 *                     @OA\Property(property="OMI", type="string"),
 *                     @OA\Property(property="examen_seins", type="string"),
 *                     @OA\Property(property="hu", type="string"),
 *                     @OA\Property(property="speculum", type="string"),
 *                     @OA\Property(property="tv", type="string"),
 *                     @OA\Property(property="fer_ac_folique", type="string"),
 *                     @OA\Property(property="milda", type="string"),
 *                     @OA\Property(property="autre_traitement", type="string"),
 *                     @OA\Property(property="maf", type="string"),
 *                     @OA\Property(property="bdcf", type="string"),
 *                     @OA\Property(property="alb", type="string"),
 *                     @OA\Property(property="vat", type="string"),
 *                     @OA\Property(property="tpi", type="string"),
 *                     @OA\Property(property="palpation", type="string"),
 *                     @OA\Property(property="bdc", type="string"),
 *                     @OA\Property(property="presentation", type="string"),
 *                     @OA\Property(property="bassin", type="string"),
 *                     @OA\Property(property="pelvimetre_externe", type="string"),
 *                     @OA\Property(property="pelvimetre_interne", type="string"),
 *                     @OA\Property(property="biischiatique", type="integer"),
 *                     @OA\Property(property="trillat", type="integer"),
 *                     @OA\Property(property="lign_innominees", type="string"),
 *                     @OA\Property(property="autre_examen", type="string"),
 *                     @OA\Property(property="resultat", type="string"),
 *                     @OA\Property(property="lieu_accouchement_apre_consentement", type="string"),
 *                     @OA\Property(property="patiente_id", type="integer"),
 *                     @OA\Property(property="visite_id", type="integer"),
 *                     @OA\Property(property="traitement", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion consultation"},
*),


 * @OA\GET(
 *     path="/api/consultations",
 *     summary="Afficher les consultation",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion consultation"},
*),


 * @OA\GET(
 *     path="/api/consultations/{id}",
 *     summary="Afficher une consultation",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion consultation"},
*),


 * @OA\DELETE(
 *     path="/api/consultations/{id}",
 *     summary="supprimer une consultation",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion consultation"},
*),


 * @OA\PUT(
 *     path="/api/consultations/{id}",
 *     summary="modifer une consultation",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="date", type="string"),
 *                     @OA\Property(property="terme", type="string"),
 *                     @OA\Property(property="SA", type="string"),
 *                     @OA\Property(property="plaintes", type="string"),
 *                     @OA\Property(property="mois", type="integer"),
 *                     @OA\Property(property="poids", type="integer"),
 *                     @OA\Property(property="taille", type="integer"),
 *                     @OA\Property(property="PB", type="integer"),
 *                     @OA\Property(property="temperature", type="integer"),
 *                     @OA\Property(property="urine", type="string"),
 *                     @OA\Property(property="sucre", type="string"),
 *                     @OA\Property(property="TA", type="string"),
 *                     @OA\Property(property="pouls", type="integer"),
 *                     @OA\Property(property="EG", type="string"),
 *                     @OA\Property(property="muqueuse", type="string"),
 *                     @OA\Property(property="mollet", type="string"),
 *                     @OA\Property(property="OMI", type="string"),
 *                     @OA\Property(property="examen_seins", type="string"),
 *                     @OA\Property(property="hu", type="string"),
 *                     @OA\Property(property="speculum", type="string"),
 *                     @OA\Property(property="tv", type="string"),
 *                     @OA\Property(property="fer_ac_folique", type="string"),
 *                     @OA\Property(property="milda", type="string"),
 *                     @OA\Property(property="autre_traitement", type="string"),
 *                     @OA\Property(property="maf", type="string"),
 *                     @OA\Property(property="bdcf", type="string"),
 *                     @OA\Property(property="alb", type="string"),
 *                     @OA\Property(property="vat", type="string"),
 *                     @OA\Property(property="tpi", type="string"),
 *                     @OA\Property(property="palpation", type="string"),
 *                     @OA\Property(property="bdc", type="string"),
 *                     @OA\Property(property="presentation", type="string"),
 *                     @OA\Property(property="bassin", type="string"),
 *                     @OA\Property(property="pelvimetre_externe", type="string"),
 *                     @OA\Property(property="pelvimetre_interne", type="string"),
 *                     @OA\Property(property="biischiatique", type="integer"),
 *                     @OA\Property(property="trillat", type="integer"),
 *                     @OA\Property(property="lign_innominees", type="string"),
 *                     @OA\Property(property="autre_examen", type="string"),
 *                     @OA\Property(property="resultat", type="string"),
 *                     @OA\Property(property="lieu_accouchement_apre_consentement", type="string"),
 *                     @OA\Property(property="sage_femme_id", type="integer"),
 *                     @OA\Property(property="patiente_id", type="integer"),
 *                     @OA\Property(property="visite_id", type="integer"),
 *                     @OA\Property(property="traitement", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion consultation"},
*),


*/

 class GestionconsultationAnnotationController {}
