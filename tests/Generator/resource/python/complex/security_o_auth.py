from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, UserList, UserDict
from .security import Security


class SecurityOAuth(Security):
    token_url: Optional[str] = Field(default=None, alias="tokenUrl")
    authorization_url: Optional[str] = Field(default=None, alias="authorizationUrl")
    scopes: Optional[List[str]] = Field(default=None, alias="scopes")
    pass


