from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union
from .type_schema import TypeSchema
from .operation import Operation
from .security import Security
from .security_api_key import SecurityApiKey
from .security_http_basic import SecurityHttpBasic
from .security_http_bearer import SecurityHttpBearer
from .security_o_auth import SecurityOAuth


# The TypeAPI Root
class TypeAPI(TypeSchema):
    base_url: Optional[str] = Field(default=None, alias="baseUrl")
    operations: Optional[Dict[str, Operation]] = Field(default=None, alias="operations")
    security: Optional[Annotated[Union[Annotated[SecurityApiKey, Tag('apiKey')], Annotated[SecurityHttpBasic, Tag('httpBasic')], Annotated[SecurityHttpBearer, Tag('httpBearer')], Annotated[SecurityOAuth, Tag('oauth2')]], Field(discriminator='type')]] = Field(default=None, alias="security")
    pass


