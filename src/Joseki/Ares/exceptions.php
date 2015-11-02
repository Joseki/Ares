<?php

namespace Joseki\Ares;

class InvalidStateException extends \RuntimeException
{
}

class ServerDoesNotResponseException extends InvalidStateException
{

}

class NotFoundException extends InvalidStateException
{

}
