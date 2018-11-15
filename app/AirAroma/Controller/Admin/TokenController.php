<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\TokenRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{

	public function __construct(Request $request, TokenRepository $tokenRepository) 
	{
		$this->tokenRepository =  $tokenRepository;
		$this->request = $request;
	}

	/**
	 * Delete token
	 */
	public function deleteToken($id)
	{
		$deleteToken = $this->tokenRepository->deleteToken($id);
		return response()->json(['status' => true, 'reason' => 'Deleted']);
	}

	/**
	 * Create new token and translation
	 */
	public function createToken()
	{
		$createToken = $this->tokenRepository->createToken($this->request->all());

		if ($createToken) {
			return response()->json(['status' => true, 'reason' => 'Saved', 'tokenId' => $createToken]);
		}

		return response()->json(['status' => false, 'reason' => 'Token already exists']);
	}


	/**
	 * Update link details 
	 */
	public function editTokenTranslation($tokenId)
	{
		$editTokenTranslation = $this->tokenRepository->editTokenTranslation($this->request->all(), $tokenId);
		
		if ($editTokenTranslation) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
	}

	/**
	 * View Token Translation
	 */
	public function getTranslation($tokenId)
	{
		$translations = $this->tokenRepository->getTranslationByTokenId($tokenId); 

		return response()->json([
			websiteId() => $translations->site_translation, 
			baseId() => $translations->base_translation
		]);
	}
}