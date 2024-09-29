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

 * @OA\GET(
 *     path="/api/patientes/3",
 *     summary="Afficher une patiente",
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
 *     tags={"gestion patiente"},
*),


 * @OA\GET(
 *     path="/api/patientes/",
 *     summary="Afficher les patientes",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion patiente"},
*),


 * @OA\DELETE(
 *     path="/api/patientes/{id}",
 *     summary="supprimer une patiente",
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
 *     tags={"gestion patiente"},
*),


 * @OA\PATCH(
 *     path="/api/patientes/5",
 *     summary="modifier une patiente",
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
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="lieu_de_naissance", type="string"),
 *                     @OA\Property(property="type", type="string"),
 *                     @OA\Property(property="date_de_naissance", type="string"),
 *                     @OA\Property(property="profession", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion patiente"},
*),


 * @OA\POST(
 *     path="/api/patientes",
 *     summary="Ajouter une patiente",
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
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="lieu_de_naissance", type="string"),
 *                     @OA\Property(property="type", type="string"),
 *                     @OA\Property(property="date_de_naissance", type="string"),
 *                     @OA\Property(property="profession", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion patiente"},
*),


*/

 class GestionpatienteAnnotationController {}
