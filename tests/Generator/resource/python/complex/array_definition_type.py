from pydantic import BaseModel, Field, GetCoreSchemaHandler
from pydantic_core import CoreSchema, core_schema
from typing import Any, Dict, Generic, List, Optional, TypeVar
from .collection_definition_type import CollectionDefinitionType


# Represents an array which contains a dynamic list of values of the same type
class ArrayDefinitionType(CollectionDefinitionType):
    pass


