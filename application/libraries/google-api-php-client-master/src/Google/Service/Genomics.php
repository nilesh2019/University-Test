<?php
/*
 * Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
/**
 * Service definition for Genomics (v1).
 *
 * <p>
 * An API to store, process, explore, and share DNA sequence reads, reference-
 * based alignments, and variant calls.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Genomics extends Google_Service
{
  
  /**
   * Constructs the internal representation of the Genomics service.
   *
   * @param Google_Client $client
   */
  public function __construct(Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://genomics.googleapis.com/';
    $this->servicePath = '';
    $this->version = 'v1';
    $this->serviceName = 'genomics';
  }
}
