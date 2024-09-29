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
 *     path="/api/accouchements",
 *     summary="Ajouter un accouchement",
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
 *                     @OA\Property(property="patiente_id", type="integer"),
 *                     @OA\Property(property="lieu", type="string"),
 *                     @OA\Property(property="mode", type="string"),
 *                     @OA\Property(property="date", type="string"),
 *                     @OA\Property(property="heure", type="string"),
 *                     @OA\Property(property="terme", type="string"),
 *                     @OA\Property(property="mois_grossesse", type="integer"),
 *                     @OA\Property(property="debut_travail", type="string"),
 *                     @OA\Property(property="perinee", type="string"),
 *                     @OA\Property(property="pathologie", type="string"),
 *                     @OA\Property(property="evolution_reanimation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion des accouchements"},
*),


 * @OA\GET(
 *     path="/api/accouchements",
 *     summary="lister les accouchements",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion des accouchements"},
*),


 * @OA\PUT(
 *     path="/api/accouchements/{id}",
 *     summary="modifier un accouchement",
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
 *                     @OA\Property(property="patiente_id", type="integer"),
 *                     @OA\Property(property="lieu", type="string"),
 *                     @OA\Property(property="mode", type="string"),
 *                     @OA\Property(property="date", type="string"),
 *                     @OA\Property(property="heure", type="string"),
 *                     @OA\Property(property="terme", type="string"),
 *                     @OA\Property(property="mois_grossesse", type="integer"),
 *                     @OA\Property(property="debut_travail", type="string"),
 *                     @OA\Property(property="perinee", type="string"),
 *                     @OA\Property(property="pathologie", type="string"),
 *                     @OA\Property(property="evolution_reanimation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"gestion des accouchements"},
*),


 * @OA\DELETE(
 *     path="/api/accouchements/{id}",
 *     summary="supprimer un accouchement",
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
 *     tags={"gestion des accouchements"},
*),


 * @OA\GET(
 *     path="/api/accouchements/{id}",
 *     summary="lister un accouchement",
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
 *     tags={"gestion des accouchements"},
*),


 * @OA\GET(
 *     path="/api/accouchements/patiente/9",
 *     summary="lister un accouchement pour une patiente",
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
 *     tags={"gestion des accouchements"},
*),


*/

 class GestiondesaccouchementsAnnotationController {}
