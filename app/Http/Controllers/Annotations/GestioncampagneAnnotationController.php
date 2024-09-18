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
 *     path="/api/campagnes",
 *     summary="Ajouter une campagne",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="path", name="nom", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="description", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="image", required=false, @OA\Schema(type="text")
 * ),
 *     @OA\Parameter(in="path", name="date_debut", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="date_fin", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="badien_gox_id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion campagne"},
*),


 * @OA\GET(
 *     path="/api/campagnes",
 *     summary="afficher les campagnes",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="nom", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="description", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="image", required=false, @OA\Schema(type="text")
 * ),
 *     @OA\Parameter(in="path", name="date_debut", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="date_fin", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="path", name="badien_gox_id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"gestion campagne"},
*),


 * @OA\GET(
 *     path="/api/campagnes/{id}",
 *     summary="afficher une campagne",
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
 *     tags={"gestion campagne"},
*),


 * @OA\DELETE(
 *     path="/api/campagnes/{id}",
 *     summary="supprimer une campagne",
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
 *     tags={"gestion campagne"},
*),


 * @OA\PUT(
 *     path="/api/campagnes/{id}",
 *     summary="modifier une campagne",
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
 *     tags={"gestion campagne"},
*),


*/

 class GestioncampagneAnnotationController {}
