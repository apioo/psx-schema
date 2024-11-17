use serde::{Serialize, Deserialize};
use any_property_type::AnyPropertyType;
use array_property_type::ArrayPropertyType;
use boolean_property_type::BooleanPropertyType;
use generic_property_type::GenericPropertyType;
use integer_property_type::IntegerPropertyType;
use map_property_type::MapPropertyType;
use number_property_type::NumberPropertyType;
use reference_property_type::ReferencePropertyType;
use string_property_type::StringPropertyType;

// Base property type
#[derive(Serialize, Deserialize)]
pub struct PropertyType {
    #[serde(rename = "deprecated")]
    deprecated: Option<bool>,

    #[serde(rename = "description")]
    description: Option<String>,

    #[serde(rename = "nullable")]
    nullable: Option<bool>,

    #[serde(rename = "type")]
    _type: Option<String>,

}

