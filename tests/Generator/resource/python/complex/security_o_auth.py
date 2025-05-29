from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .security import Security


class SecurityOAuth(Security):
    authorization_url: Optional[str] = Field(default=None, alias="authorizationUrl")
    scopes: Optional[List[str]] = Field(default=None, alias="scopes")
    token_url: Optional[str] = Field(default=None, alias="tokenUrl")
    pass


